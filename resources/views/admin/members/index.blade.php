@extends('layouts.admin')

@section('content')
<div class="bg-white p-4 rounded-3 shadow-sm">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Daftar Member</h4>
        <a href="{{ route('admin.members.create') }}" class="btn btn-primary rounded-pill px-4 fw-bold">
            <i class="fas fa-plus me-1"></i> Tambah Anggota
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light text-center">
                <tr>
                    <th width="5%">No</th>
                    <th width="10%">Foto</th>
                    <th width="10%">ID</th>
                    <th>Nama</th>
                    <th>No Telepon</th>
                    <th>Email</th>
                    <th width="10%">Status</th> 
                    <th width="20%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($members as $index => $member)
                <tr>
                    <td class="text-center">{{ $members->firstItem() + $index }}</td>
                    
                    <td class="text-center">
                        @if($member->photo)
                            <img src="{{ asset('storage/' . $member->photo) }}" 
                                 alt="Foto" 
                                 class="rounded-circle border shadow-sm" 
                                 style="width: 40px; height: 40px; object-fit: cover;">
                        @else
                            <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center border mx-auto" 
                                 style="width: 40px; height: 40px;">
                                <i class="fas fa-user text-secondary small"></i>
                            </div>
                        @endif
                    </td>

                    <td class="text-center fw-bold">{{ $member->member_code }}</td>
                    <td>{{ $member->name }}</td>
                    <td>{{ $member->phone }}</td>
                    <td>{{ $member->email }}</td>
                    
                    <td class="text-center">
                        @if($member->is_active)
                            <span class="badge bg-success">Aktif</span>
                        @else
                            <span class="badge bg-danger">Non-Aktif</span>
                        @endif
                    </td>

                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-1">
                            <a href="{{ route('admin.members.show', $member->id) }}" class="btn btn-sm btn-success text-white" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </a>

                            <a href="{{ route('admin.members.edit', $member->id) }}" class="btn btn-sm btn-info text-white" title="Edit Data">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form onsubmit="return confirm('PERINGATAN: Anda yakin ingin menghapus member ini secara PERMANEN? Data yang dihapus tidak bisa dikembalikan.');" 
                                  action="{{ route('admin.members.destroy', $member->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus Permanen">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-5 text-muted">
                        <i class="fas fa-users fa-3x mb-3"></i><br>
                        Belum ada data member. Silakan tambah baru!
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-end mt-4">
        {{ $members->links() }}
    </div>

</div>
@endsection