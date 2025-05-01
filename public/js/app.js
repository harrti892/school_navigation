require('./bootstrap'); // Laravel 預設引入

console.log("✅ app.js loaded");

// 你可以在這裡新增互動程式，例如：節點點擊或邊建立
document.addEventListener("DOMContentLoaded", function () {
    const nodes = document.querySelectorAll(".node");
    nodes.forEach(node => {
        node.addEventListener("click", () => {
            node.classList.toggle("selected");
            console.log(`🟠 點擊節點：${node.dataset.id || node.textContent}`);
        });
    });
});
