<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Inertia\Inertia;

class CourseController extends Controller
{
    public function index()
    {
        $this->authorize('viewAnyAsStudent', Course::class);
        $query = Course::query();

        if (request()->has('search')) {
            $searchTerm = request()->search;
            $query->where('title', 'LIKE', '%'.$searchTerm.'%');
        }

        $courses = $query->paginate(9)->withQueryString();

        return Inertia::render('Student/Courses/Index', [
            'courses' => $courses,
        ]);
    }

    public function show(Course $course)
    {
        $this->authorize('viewAsStudent', Course::class);

        return Inertia::render('Student/Courses/Show', [
            'course' => $course,
        ]);
    }

    public function joinCourse(Course $course)
    {
        // TODO: authorize
        $course->users()->attach(auth()->id());

        return redirect()->back();
    }
}
