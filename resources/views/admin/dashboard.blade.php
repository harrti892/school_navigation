<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>管理後台</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-white">
    <div class="container py-5">
        <h2 class="mb-4">🛠️ 管理後台</h2>
        <div class="d-flex flex-column gap-3">
            <a href="{{ url('/map-editor') }}" class="btn btn-primary">
                🗺️ 地圖編輯器
            </a>
            <a href="{{ url('/admin/settings') }}" class="btn btn-secondary">
                ⚙️ 系統設定（範例連結）
            </a>
        </div>
    </div>
</body>
</html>
