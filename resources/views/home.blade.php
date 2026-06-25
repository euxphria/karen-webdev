@extends('common.main')
@section('title','Home')
@section('content')

<div class="tabs-container">
    <div class="tabs-nav">
        <button class="tab-btn active" data-tab="announcements">Announcements</button>
        <button class="tab-btn" data-tab="enrollment">Enrollment</button>
        <button class="tab-btn" data-tab="schedule">Schedule</button>
    </div>

    <div class="tabs-content">
        <div class="tab-pane active" id="announcements">
            <!-- announcements content goes here -->
        </div>
        <div class="tab-pane" id="enrollment">
            <div class="text-center mt-4">
                <h5 style="color: #007dc4;">Enrollment is now open.</h5>
                <p style="color: #555; font-size: 14px;">Click the button below to view available subjects and select your schedule.</p>
                <a href="{{ route('enrollment.index') }}" class="btn btn-ghost mt-2">Enroll Now</a>
            </div>
        </div>
        </div>
        <div class="tab-pane" id="schedule">
            <!-- schedule content goes here -->
        </div>
    </div>
</div>

<style>
    .tabs-nav {
        display: flex;
        gap: 10px;
        border-bottom: 2px solid #e0e0e0;
    }

    .tab-btn {
        padding: 0.75rem 1.5rem;
        background: none;
        border: none;
        font-size: 16px;
        font-weight: 500;
        color: #555;
        cursor: pointer;
        border-bottom: 3px solid transparent;
        transition: all 0.2s ease;
    }

    .tab-btn:hover {
        color: #007dc4;
    }

    .tab-btn.active {
        color: #007dc4;
        border-bottom: 3px solid #007dc4;
    }

    .tab-pane {
        display: none;
        padding: 20px 0;
    }

    .tab-pane.active {
        display: block;
    }
</style>

<script>
    document.querySelectorAll('.tab-btn').forEach(button => {
        button.addEventListener('click', () => {
            // remove active from all buttons and panes
            document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
            document.querySelectorAll('.tab-pane').forEach(pane => pane.classList.remove('active'));

            // activate clicked tab
            button.classList.add('active');
            document.getElementById(button.dataset.tab).classList.add('active');
        });
    });
</script>

<style>

.hero {
    justify-content: center;
    text-align: center;
    padding: 60px;
}

</style>

@endsection