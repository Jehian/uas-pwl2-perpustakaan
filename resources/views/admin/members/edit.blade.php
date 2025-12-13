@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Edit Member</h4>
            <span class="badge {{ $member->is_active ? 'bg-success' : 'bg-danger' }}">
                {{ $member->is_active ? 'Status: Aktif' : 'Status: Non-Aktif' }}
            </span>
        </div>
        
        <div class="d-flex gap-2">
            @if($member->is_active)
                <form onsubmit="return confirm('Non-aktifkan member ini? Dia tidak akan bisa meminjam buku lagi, tapi datanya TETAP ADA.');" 
                      action="{{ route('admin.members.update_status', $member->id) }}" method="POST">
                    @csrf @method('PATCH')
                    <input type="hidden" name="is_active" value="0">
                    
                    <button type="submit" class="btn btn-danger rounded-pill px-4 fw-bold">
                        <i class="fas fa-ban me-1"></i> Non-aktifkan Member
                    </button>
                </form>
            @else
                <form onsubmit="return confirm('Aktifkan kembali member ini?');" 
                      action="{{ route('admin.members.update_status', $member->id) }}" method="POST">
                    @csrf @method('PATCH')
                    <input type="hidden" name="is_active" value="1">
                    
                    <button type="submit" class="btn btn-success rounded-pill px-4 fw-bold">
                        <i class="fas fa-check-circle me-1"></i> Aktifkan Kembali
                    </button>
                </form>
            @endif

            <a href="{{ route('admin.members.index') }}" class="btn btn-secondary rounded-pill px-4">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-4">
            <form action="{{ route('admin.members.update', $member->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT') 
                
                <div class="row">
                    <div class="col-md-4 text-center mb-4 mb-md-0 border-end">
                        <label class="form-label fw-bold d-block mb-3">Foto Profil</label>
                        
                        <div class="mb-3 position-relative d-inline-block">
                            @if($member->photo)
                                <img src="{{ asset('storage/' . $member->photo) }}" alt="Foto Profil" 
                                     class="rounded-circle img-thumbnail shadow-sm" 
                                     style="width: 180px; height: 180px; object-fit: cover;">
                            @else
                                <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center shadow-sm" 
                                     style="width: 180px; height: 180px;">
                                    <i class="fas fa-user fa-4x text-secondary"></i>
                                </div>
                            @endif
                        </div>

                        <div class="mx-auto" style="max-width: 250px;">
                            <label class="btn btn-outline-primary btn-sm w-100 cursor-pointer">
                                <i class="fas fa-camera me-1"></i> Ganti Foto
                                <input type="file" name="photo" class="d-none" accept="image/*" onchange="previewImage(this)">
                            </label>
                            <small class="text-muted d-block mt-2" style="font-size: 11px;">Format: JPG, PNG. Max 2MB.</small>
                        </div>
                    </div>

                    <div class="col-md-8 ps-md-4">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small text-uppercase text-muted">Kode Member</label>
                                <input type="text" class="form-control bg-light fw-bold text-primary" value="{{ $member->member_code }}" readonly>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small text-uppercase text-muted">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control" value="{{ $member->name }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small text-uppercase text-muted">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ $member->email }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small text-uppercase text-muted">Nomor Telepon</label>
                                <input type="text" name="phone" class="form-control" value="{{ $member->phone }}" required>
                            </div>

                            <div class="col-12 mt-3">
                                <hr class="text-muted opacity-25">
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary px-5 py-2 fw-bold rounded-pill shadow-sm">
                                        <i class="fas fa-save me-1"></i> Simpan Perubahan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                document.querySelector('.img-thumbnail').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection