@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <h2 class="text-center mb-4">{{ $currentFloor }} 地圖編輯器</h2>

    {{-- 樓層切換下拉選單 --}}
    <div class="mb-3">
        <label for="floor-select" class="form-label">選擇樓層</label>
        <select id="floor-select" class="form-select" onchange="location.href='?floor=' + this.value">
            @foreach ($floorList as $floor => $path)
                <option value="{{ $floor }}" @selected($floor == $currentFloor)>
                    {{ $floor }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- 邊圖層（SVG 畫線） --}}
    <svg id="edges-layer" class="position-absolute top-0 start-0 w-100 h-100"
        style="pointer-events: none;" xmlns="http://www.w3.org/2000/svg">
        <defs>
            <marker id="arrow" markerWidth="10" markerHeight="10" refX="10" refY="5"
                    orient="auto" markerUnits="strokeWidth">
                <path d="M0,0 L10,5 L0,10 z" fill="red" />
            </marker>
        </defs>
        @foreach ($edges as $edge)
            @php
                $from = $nodes->firstWhere('node_id', $edge->from_node);
                $to = $nodes->firstWhere('node_id', $edge->to_node);
            @endphp
            @if ($from && $to)
                <line
                    x1="{{ $from->svg_x }}%" y1="{{ $from->svg_y }}%"
                    x2="{{ $to->svg_x }}%" y2="{{ $to->svg_y }}%"
                    stroke="red" stroke-width="2"
                    marker-end="url(#arrow)"
                    data-edge-id="{{ $edge->id }}"
                />
            @endif
        @endforeach
    </svg>



    {{-- 地圖顯示與節點圖層 --}}
    <div id="map-container" class="position-relative" style="width: 100%; height: 600px; border: 1px solid #ccc;">
        {{-- SVG 地圖 --}}
        <object data="{{ $floorList[$currentFloor] }}" type="image/svg+xml" width="100%" height="100%"></object>

        {{-- 節點圖層 --}}
        @foreach ($nodes as $node)
            <div class="node position-absolute bg-primary text-white px-2 py-1 rounded small"
                 data-id="{{ $node->node_id }}"
                 style="left: {{ $node->svg_x }}%; top: {{ $node->svg_y }}%; transform: translate(-50%, -50%);">
                {{ $node->node_id }}
            </div>
        @endforeach
    </div>
</div>
@endsection

@section('scripts')
<script>
    let selectedNode = null;
    let edgeStart = null;

    document.getElementById('map-container').addEventListener('click', function (e) {
        // 點擊新增節點（只有點地圖空白區域）
        if (e.target.id === 'map-container') {
            const rect = this.getBoundingClientRect();
            const x = ((e.clientX - rect.left) / rect.width) * 100;
            const y = ((e.clientY - rect.top) / rect.height) * 100;

            const nodeId = prompt('輸入節點 ID：');
            if (nodeId) {
                fetch("{{ route('nodes.store') }}", {
                    method: "POST",
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        node_id: nodeId,
                        svg_x: x.toFixed(2),
                        svg_y: y.toFixed(2),
                        floor: "{{ $currentFloor }}"
                    })
                }).then(res => location.reload());
            }
        }
    });

    document.querySelectorAll('.node').forEach(node => {
        node.addEventListener('click', function (e) {
            e.stopPropagation();
            const id = this.dataset.id;

            if (edgeStart) {
                // 第二次點，建立邊
                fetch("{{ route('edges.store') }}", {
                    method: "POST",
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        from_node: edgeStart,
                        to_node: id
                    })
                }).then(res => location.reload());
                edgeStart = null;
            } else {
                // 第一次點，準備選邊
                edgeStart = id;
                alert('選擇了 ' + id + '，請點選另一個節點來建立邊');
            }
        });

        node.addEventListener('contextmenu', function (e) {
            e.preventDefault();
            const id = this.dataset.id;
            if (confirm(`刪除節點 ${id}？這也會刪除相關邊。`)) {
                fetch(`{{ url('admin/nodes') }}/${id}`, {
                    method: "DELETE",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    }
                }).then(res => location.reload());
            }
        });
    });

    // 點右鍵刪除邊（需要開啟事件監聽）
    document.querySelectorAll('#edges-layer line').forEach(line => {
        line.addEventListener('contextmenu', function(e) {
            e.preventDefault();
            const edgeId = this.dataset.edgeId;
            if (confirm(`刪除此邊 ID ${edgeId}？`)) {
                fetch(`{{ url('admin/edges') }}/${edgeId}`, {
                    method: "DELETE",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    }
                }).then(res => location.reload());
            }
        });
    });

    let tempLine = null;

    // 點擊節點選邊
    document.querySelectorAll('.node').forEach(node => {
        node.addEventListener('click', function (e) {
            e.stopPropagation();
            const id = this.dataset.id;

            if (edgeStart) {
                // 點第二個節點 → 建立邊
                fetch("{{ route('edges.store') }}", {
                    method: "POST",
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        from_node: edgeStart,
                        to_node: id
                    })
                }).then(res => location.reload());

                // 清除樣式與虛線
                document.querySelectorAll('.node').forEach(n => n.classList.remove('selected'));
                edgeStart = null;
                if (tempLine) tempLine.remove();
            } else {
                // 選第一個節點
                edgeStart = id;
                this.classList.add('selected');

                // 建立臨時虛線
                const x = parseFloat(this.style.left);
                const y = parseFloat(this.style.top);

                const svg = document.getElementById('edges-layer');
                tempLine = document.createElementNS("http://www.w3.org/2000/svg", "line");
                tempLine.setAttribute("id", "temp-line");
                tempLine.setAttribute("x1", `${x}%`);
                tempLine.setAttribute("y1", `${y}%`);
                tempLine.setAttribute("x2", `${x}%`);
                tempLine.setAttribute("y2", `${y}%`);
                svg.appendChild(tempLine);
            }
        });
    });

    // 跟隨滑鼠移動臨時虛線
    document.getElementById('map-container').addEventListener('mousemove', function (e) {
        if (tempLine && edgeStart) {
            const rect = this.getBoundingClientRect();
            const x = ((e.clientX - rect.left) / rect.width) * 100;
            const y = ((e.clientY - rect.top) / rect.height) * 100;
            tempLine.setAttribute("x2", `${x}%`);
            tempLine.setAttribute("y2", `${y}%`);
        }
    });

    // 取消邊建立狀態
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            edgeStart = null;
            document.querySelectorAll('.node').forEach(n => n.classList.remove('selected'));
            if (tempLine) {
                tempLine.remove();
                tempLine = null;
            }
        }
    });

    document.getElementById('map-container').addEventListener('click', function (e) {
        // 如果點擊不是節點，也不是邊（空白處）
        if (!e.target.classList.contains('node') && e.target.tagName !== 'line') {
            edgeStart = null;
            document.querySelectorAll('.node').forEach(n => n.classList.remove('selected'));
            if (tempLine) {
                tempLine.remove();
                tempLine = null;
            }
        }
    });


</script>
@endsection
