<!DOCTYPE html>
<html lang="zh-Hant">
<head>
  <meta charset="UTF-8">
  <title>智慧導航系統</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    #map {
      width: 100%;
      height: 500px;
      background: url('/images/sample_map.png') center center no-repeat;
      background-size: contain;
      border: 1px solid #ccc;
      position: relative;
    }
    .marker {
      width: 20px;
      height: 20px;
      background: red;
      border-radius: 50%;
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
    }
  </style>
</head>
<body>
<div class="container py-5">
  <h2 class="mb-4 text-center">📍 校園智慧導航</h2>

  <div class="mb-3">
    <label for="target" class="form-label">選擇目標教室</label>
    <select class="form-select" id="target">
      <option selected disabled>請選擇...</option>
      <option value="A101">A101</option>
      <option value="A102">A102</option>
      <option value="A201">A201</option>
    </select>
  </div>

  <div class="mb-3 text-center">
    <button class="btn btn-primary me-2" onclick="startNavigation()">開始導航</button>
    <a href="{{ url('/') }}" class="btn btn-secondary">返回首頁</a>
  </div>

  <div id="map">
    <div class="marker" title="你在這裡"></div>
  </div>
</div>

<script>
  function startNavigation() {
    const target = document.getElementById("target").value;
    if (!target) {
      alert("請先選擇教室！");
      return;
    }
    alert("模擬導航至：" + target);
    // 可改為動畫/連接 API 路徑規劃
  }
</script>
</body>
</html>
