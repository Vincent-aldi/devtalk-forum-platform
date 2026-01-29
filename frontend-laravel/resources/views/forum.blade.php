<!DOCTYPE html>
<html>
<head>
    <title>DevTalk Forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2 class="mb-4 text-center">DevTalk Microservice Forum</h2>
        
        <div class="row g-4">
            <div class="col-md-5">
                <div class="card p-3 shadow-sm border-0">
                    <h5 class="text-primary">Join Forum (User Service)</h5>
                    <form action="/join" method="POST">
                        @csrf
                        <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
                        <input type="password" name="password" class="form-control mb-2" placeholder="Password" required>
                        <button class="btn btn-primary w-100">Daftar</button>
                    </form>
                </div>
            </div>

            <div class="col-md-7">
                <div class="card p-3 shadow-sm border-0 mb-4">
                    <h5 class="text-success">Post Comment (Comment Service)</h5>
                    <form action="/comment" method="POST">
                        @csrf
                        <input type="number" name="userId" class="form-control mb-2" placeholder="User ID" required>
                        <textarea name="content" class="form-control mb-2" placeholder="Tulis komentar..." required></textarea>
                        <button class="btn btn-success w-100">Kirim Komentar</button>
                    </form>
                </div>

                <h5 class="mt-4 mb-3">Feed Diskusi</h5>
                @if(isset($comments) && count($comments) > 0)
                    @foreach($comments as $c)
                    <div class="card p-3 shadow-sm border-0 mb-2">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="badge bg-secondary mb-2">User ID: {{ $c['userId'] }}</span>
                                <p class="mb-1 text-dark">{{ $c['content'] }}</p>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($c['createdAt'])->diffForHumans() }}</small>
                            </div>
                            <div class="d-flex gap-1">
                                <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $c['id'] }}">Edit</button>
                                
                                <form action="/comment/{{ $c['id'] }}" method="POST" onsubmit="return confirm('Hapus komentar ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="editModal{{ $c['id'] }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="/comment/{{ $c['id'] }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Komentar</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <textarea name="content" class="form-control" rows="3" required>{{ $c['content'] }}</textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-warning">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    @endforeach
                @else
                    <p class="text-muted text-center italic">Belum ada komentar.</p>
                @endif
            </div>
        </div>
    </div>
</body>
</html>