<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Models\Course;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class CourseController extends Controller
{
    public function index(): Response
    {
        $this->authorize('viewAnyAsAdmin', Course::class);
        $query = Course::query();

        if (request()->has('search')) {
            $searchTerm = request()->input('search');
            $query->where('title', 'LIKE', '%'.$searchTerm.'%');
        }

        if (request()->query('sort')) {
            $attribute = request()->query('sort');
            $order = 'ASC';

            if (str_starts_with($attribute, '-')) {
                $order = 'DESC';
                $attribute = substr($attribute, 1);
            }

            $query->orderBy($attribute, $order);
        }

        $courses = $query->paginate(10)->withQueryString();

        return Inertia::render('Admin/Courses/Index', [
            'courses' => $courses,
        ]);
    }

    public function create(): Response
    {
        $this->authorize('createAsAdmin', Course::class);

        return Inertia::render('Admin/Courses/Create');
    }

    public function store(StoreCourseRequest $request): RedirectResponse
    {
        $this->authorize('createAsAdmin', Course::class);
        $file = $request->file('image');

        if ($file) {
            $fileName = time().'_'.$file->getClientOriginalName();
            $path = Storage::disk('public')->putFileAs('courses', $file, $fileName);

            $validated = $request->except('image');

            Course::create($validated + [
                'image' => $path,
            ]);
        }

        return to_route('admin.courses.index');
    }

    public function edit(Course $course): Response
    {
        $this->authorize('updateAsAdmin', Course::class);

        return Inertia::render('Admin/Courses/Edit', [
            'course' => $course,
        ]);
    }

    public function updateCourse(UpdateCourseRequest $request, Course $course): RedirectResponse
    {
        $this->authorize('updateAsAdmin', Course::class);
        $validated = $request->except('image');
        $file = $request->file('image');

        if ($file) {
            $fileName = time().'_'.$file->getClientOriginalName();
            $path = Storage::disk('public')->putFileAs('courses', $file, $fileName);

            $validated = $validated + ['image' => $path];

            $course->deleteLocalImage($course->image);
        }

        $course->update($validated);

        return redirect()->back();
    }

    public function destroy(Course $course): RedirectResponse
    {
        $this->authorize('deleteAsAdmin', Course::class);
        $course->deleteLocalImage($course->image);
        $course->delete();

        return to_route('admin.courses.index');
    }
}
