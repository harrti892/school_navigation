<!-- resources/views/home.blade.php -->
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>校園導航系統</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light text-center">
    <div class="container py-5">
        <h1 class="mb-4">🎓 校園智慧導航系統</h1>
        <p class="lead">請從下方選擇功能進入系統</p>
        <div class="d-flex justify-content-center gap-3 mt-4">
            <a href="{{ url('/navigation') }}" class="btn btn-success">📍 開始導航</a>
            <a href="{{ url('/admin') }}" class="btn btn-warning">🛠️ 管理後台</a>
        </div>
    </div>
</body>
</html>
