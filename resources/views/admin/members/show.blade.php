@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    
    <div class="mb-4">
        <a href="{{ route('admin.members.index') }}" class="text-decoration-none text-secondary">
            <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar Member
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="bg-white p-5 rounded-3 shadow-sm d-flex flex-column flex-md-row align-items-center align-items-md-start gap-5">
                
                <div class="text-center">
                    <div class="position-relative mb-3">
                        @if($member->photo)
                            <img src="{{ asset('storage/' . $member->photo) }}" 
                                 class="rounded-circle shadow-sm border p-1" 
                                 style="width: 180px; height: 180px; object-fit: cover;">
                        @else
                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center shadow-sm" 
                                 style="width: 180px; height: 180px;">
                                <i class="fas fa-user fa-5x text-secondary opacity-25"></i>
                            </div>
                        @endif
                        
                        <span class="position-absolute bottom-0 end-0 badge rounded-pill border border-2 border-white {{ $member->is_active ? 'bg-success' : 'bg-danger' }}">
                            {{ $member->is_active ? 'AKTIF' : 'NON-AKTIF' }}
                        </span>
                    </div>
                    
                    <h4 class="fw-bold mb-1">{{ $member->name }}</h4>
                    <span class="text-muted font-monospace bg-light px-2 py-1 rounded">{{ $member->member_code }}</span>
                </div>

                <div class="flex-grow-1 w-100">
                    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
                        <h5 class="fw-bold text-primary m-0">Informasi Pribadi</h5>
                        <a href="{{ route('admin.members.edit', $member->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                            <i class="fas fa-edit me-1"></i> Edit
                        </a>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="small text-muted fw-bold">EMAIL</label>
                            <div class="fs-6">{{ $member->email }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="small text-muted fw-bold">NO. TELEPON</label>
                            <div class="fs-6">{{ $member->phone }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="small text-muted fw-bold">BERGABUNG SEJAK</label>
                            <div class="fs-6">{{ $member->created_at->format('d F Y') }}</div>
                        </div>
                        
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection