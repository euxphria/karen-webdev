@extends('common.main')
@section('title', 'Enrollment')

@section('content')

<div class="container">

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        @foreach($errors->all() as $error)
            <div class="alert alert-danger">
                {{ $error }}
            </div>
        @endforeach
    @endif

    @if($alreadyEnrolled)

        <div class="status-banner">
            You already submitted your enrollment.
            Please wait for approval.
        </div>

    @else

        <div class="enroll-box shadow-lg">

            <h2 class="enroll-title">
                Subject Enrollment
            </h2>

            <p class="enroll-sub">
                Select your schedule for each subject below.
            </p>

            <form method="POST" action="{{ route('enrollment.store') }}">
                @csrf

                <table class="table table-hover">

                    <thead>
                        <tr>
                        <th>Select</th>
                        <th>Subject Code</th>
                        <th>Subject Title</th>
                        <th>Units</th>
                        <th>Schedule</th>
                    </tr>
                    </thead>

                    <tbody>

                        @forelse($grouped as $code => $offerings)

                            <tr>

                                <td>
                                    <input
                                        type="checkbox"
                                        class="subject-checkbox"
                                        name="selected_subjects[]"
                                        value="{{ $offerings->first()->subject_id }}"
                                    >
                                </td>

                                <td>
                                    {{ $code }}
                                </td>

                                <td>
                                    {{ $offerings->first()->course_name }}
                                </td>

                                <td>
                                    {{ $offerings->first()->units }}
                                </td>

                                <td>

                                    @if($offerings->first()->section_id === null)

                                        <span class="text-muted">
                                            No section available
                                        </span>

                                    @else

                                        @foreach($offerings as $section)

                                            <div class="form-check mb-1">

                                                <input
                                                class="form-check-input section-radio"
                                                type="radio"
                                                name="sections[{{ $section->subject_id }}]"
                                                value="{{ $section->section_id }}"
                                                id="section-{{ $section->section_id }}"
                                                disabled
                                            >

                                                <label
                                                    class="form-check-label"
                                                    for="section-{{ $section->section_id }}"
                                                >

                                                    {{ $section->section_code }}
                                                    —

                                                    {{ $section->day_schedule }}

                                                    (
                                                    {{ \Carbon\Carbon::parse($section->start_time)->format('h:i A') }}
                                                    -
                                                    {{ \Carbon\Carbon::parse($section->end_time)->format('h:i A') }}
                                                    )

                                                    |

                                                    {{ $section->professor }}

                                                </label>

                                            </div>

                                        @endforeach

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="4" class="text-center text-muted">
                                    No subjects available for your program and year level.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

                <button type="submit" class="btn btn-submit">
                    Submit Enrollment
                </button>

            </form>

        </div>

    @endif

</div>

<style>

.enroll-box{
    background-color:#fff;
    border-radius:15px;
    padding:30px;
    margin-top:30px;
    margin-bottom:50px;
}

.enroll-title{
    color:#007dc4;
    font-weight:bold;
}

.enroll-sub{
    color:#555;
    margin-bottom:20px;
}

.status-banner{
    background:#007dc4;
    color:#fff;
    padding:15px;
    border-radius:10px;
    margin-top:30px;
    font-weight:500;
}

.btn-submit{
    background:#007dc4;
    color:#fff;
    border-radius:30px;
    padding:10px 30px;
    margin-top:15px;
    border:none;
}

.btn-submit:hover{
    background:#4896c3;
}

.table th{
    background:#f8f9fa;
}

.form-check{
    margin-bottom:6px;
}

</style>

<script>
document.addEventListener('DOMContentLoaded', function(){

    const rows = document.querySelectorAll('tbody tr');

    rows.forEach(row => {

        const checkbox = row.querySelector('.subject-checkbox');

        if(!checkbox) return;

        const radios = row.querySelectorAll('.section-radio');

        checkbox.addEventListener('change', function(){

            radios.forEach(radio => {

                radio.disabled = !checkbox.checked;

                if(!checkbox.checked){
                    radio.checked = false;
                }

            });

        });

    });

});
</script>

@endsection