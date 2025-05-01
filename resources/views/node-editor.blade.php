<!DOCTYPE html>
<html lang="zh">
<head>
  <meta charset="UTF-8">
  <title>節點定位編輯</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <style>
    .image-wrapper {
      position: relative;
      display: inline-block;
    }

    .image-wrapper img {
      max-width: 100%;
    }

    .node {
      position: absolute;
      width: 12px;
      height: 12px;
      background: red;
      border-radius: 50%;
      transform: translate(-50%, -50%);
      cursor: pointer;
    }
  </style>
</head>
<body>
  <h1>圖片節點設定</h1>

  <div class="image-wrapper" onclick="placeNode(event)">
    <img src="/images/map.jpg" id="mapImage">
    <div id="nodesContainer"></div>
  </div>

  <button onclick="saveNodes()">儲存節點</button>

  <script>
    const nodes = [];

    function placeNode(event) {
      const image = document.getElementById('mapImage');
      const rect = image.getBoundingClientRect();
      const x = ((event.clientX - rect.left) / rect.width) * 100;
      const y = ((event.clientY - rect.top) / rect.height) * 100;

      nodes.push({ x, y });
      renderNode(x, y);
    }

    function renderNode(x, y) {
      const node = document.createElement('div');
      node.className = 'node';
      node.style.left = x + '%';
      node.style.top = y + '%';
      document.getElementById('nodesContainer').appendChild(node);
    }

    function saveNodes() {
      fetch('{{ route("nodes.store") }}', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ nodes })
      })
      .then(res => res.json())
      .then(data => alert("✅ 儲存成功"))
      .catch(err => alert("❌ 儲存失敗"));
    }
  </script>
</body>
</html>
