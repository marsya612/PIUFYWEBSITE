<header class="bg-white border-bottom px-4 py-2">
    <div class="d-flex align-items-center justify-content-between">

        <!-- LEFT: Logo -->
        <div class="d-flex align-items-center">
            <h5 class="mb-0 fw-bold">piufy</h5>
        </div>


        <!-- RIGHT: Notification + User -->
        <div class="d-flex align-items-center gap-3">

            <!-- Notification -->
            {{-- <div class="position-relative">
                <span style="font-size: 18px;">🔔</span>
            </div> --}}
            <a href="{{ route('notifikasi') }}" class="position-relative text-decoration-none">
                <span style="font-size: 18px;">🔔</span>
            </a>

            <!-- User Info -->
            <a href="{{ route('profile') }}" class="text-decoration-none text-dark">
                <div class="d-flex align-items-center bg-light px-3 py-1 rounded-pill profile-hover">

                    @if(auth()->user()->photo)
                        <img src="{{ asset('storage/' . auth()->user()->photo) }}"
                            class="rounded-circle me-2 profile-img"
                            style="width:30px; height:30px; object-fit:cover;">
                    @else
                        <span class="me-2">👤</span>
                    @endif

                    <span class="fw-medium">
                        {{ auth()->user()->name ?? 'User' }}
                    </span>

                </div>
            </a>

        </div>

    </div>
</header>