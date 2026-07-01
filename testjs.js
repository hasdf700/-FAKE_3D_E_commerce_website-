//生成1F店面
// 1. 擴充商店資料
const shopData = [
    {
        name: "星辰咖啡",
        img: "store_Coffee.webp",
        desc: "提供頂級手沖咖啡與宇宙級的寧靜空間，適合放鬆與思考。",
        products: [
            { name: "黑洞拿鐵", price: "$150", img: "test.jpg", info: "深邃濃郁的配方" },
            { name: "銀河花茶", price: "$120", img: "test.jpg", info: "帶有淡淡清香" },
            { name: "銀河花茶", price: "$120", img: "test.jpg", info: "帶有淡淡清香" },
            { name: "銀河花茶", price: "$120", img: "test.jpg", info: "帶有淡淡清香" }
        ]
    },
    {
        name: "極光電玩",
        img: "store_Game.webp",
        desc: "最齊全的次世代主機與復古機台，沉浸在霓虹光影的遊戲世界。",
        products: [
            { name: "黑洞拿鐵", price: "$150", img: "test.jpg", info: "深邃濃郁的配方" },
            { name: "銀河花茶", price: "$120", img: "test.jpg", info: "帶有淡淡清香" },
            { name: "銀河花茶", price: "$120", img: "test.jpg", info: "帶有淡淡清香" },
            { name: "銀河花茶", price: "$120", img: "test.jpg", info: "帶有淡淡清香" }
        ]
    },
    {
        name: "霓虹書坊",
        img: "store_Book.webp",
        desc: "收錄了無數實體書與電子卷軸，尋找失傳的數位智慧。",
        products: [
            { name: "黑洞拿鐵", price: "$150", img: "test.jpg", info: "深邃濃郁的配方" },
            { name: "銀河花茶", price: "$120", img: "test.jpg", info: "帶有淡淡清香" },
            { name: "銀河花茶", price: "$120", img: "test.jpg", info: "帶有淡淡清香" },
            { name: "銀河花茶", price: "$120", img: "test.jpg", info: "帶有淡淡清香" }
        ]
    },
    {
        name: "月影酒吧", img: "store_Beer.webp", desc: "夜晚最Chill的去處。", products: [
            { name: "黑洞拿鐵", price: "$150", img: "test.jpg", info: "深邃濃郁的配方" },
            { name: "銀河花茶", price: "$120", img: "test.jpg", info: "帶有淡淡清香" },
            { name: "銀河花茶", price: "$120", img: "test.jpg", info: "帶有淡淡清香" },
            { name: "銀河花茶", price: "$120", img: "test.jpg", info: "帶有淡淡清香" }
        ]
    },
    {
        name: "毛毛工坊", img: "store_ChillNeko.webp", desc: "東方周邊相關商品販售。", products: [
            { name: "黑洞拿鐵", price: "$150", img: "test.jpg", info: "深邃濃郁的配方" },
            { name: "銀河花茶", price: "$120", img: "test.jpg", info: "帶有淡淡清香" },
            { name: "銀河花茶", price: "$120", img: "test.jpg", info: "帶有淡淡清香" },
            { name: "銀河花茶", price: "$120", img: "test.jpg", info: "帶有淡淡清香" }
        ]

    },
    {
        name: "加賀火鍋", img: "store_Hotpot.webp", desc: "暖心暖胃的日式火鍋。", products: [
            { name: "黑洞拿鐵", price: "$150", img: "test.jpg", info: "深邃濃郁的配方" },
            { name: "銀河花茶", price: "$120", img: "test.jpg", info: "帶有淡淡清香" },
            { name: "銀河花茶", price: "$120", img: "test.jpg", info: "帶有淡淡清香" },
            { name: "銀河花茶", price: "$120", img: "test.jpg", info: "帶有淡淡清香" },
            { name: "銀河花茶", price: "$120", img: "test.jpg", info: "帶有淡淡清香" },
            { name: "銀河花茶", price: "$120", img: "test.jpg", info: "帶有淡淡清香" },
            { name: "銀河花茶", price: "$120", img: "test.jpg", info: "帶有淡淡清香" },
            { name: "銀河花茶", price: "$120", img: "test.jpg", info: "帶有淡淡清香" },
            { name: "銀河花茶", price: "$120", img: "test.jpg", info: "帶有淡淡清香" },
            { name: "銀河花茶", price: "$120", img: "test.jpg", info: "帶有淡淡清香" },
            { name: "銀河花茶", price: "$120", img: "test.jpg", info: "帶有淡淡清香" },
            { name: "銀河花茶", price: "$120", img: "test.jpg", info: "帶有淡淡清香" }
        ]
    },
    {
        name: "時光花店", img: "store_Flower.webp", desc: "永不凋謝的電子花卉。", products: [
            { name: "黑洞拿鐵", price: "$150", img: "test.jpg", info: "深邃濃郁的配方" },
            { name: "銀河花茶", price: "$120", img: "test.jpg", info: "帶有淡淡清香" },
            { name: "銀河花茶", price: "$120", img: "test.jpg", info: "帶有淡淡清香" },
            { name: "銀河花茶", price: "$120", img: "test.jpg", info: "帶有淡淡清香" }
        ]
    }
];
// 2. 產生店面的函數
function renderShops1F(containerId) {
    const container = document.getElementById(containerId);
    if (!container) return;

    // 將 <a> 改為 <div> 並綁定 onclick，傳入陣列索引
    const htmlContent = shopData.map((data, index) => `
        <div class="shop" onclick="showShopDetail(${index})" style="z-index:10; cursor:pointer;">
            <div class="signboard">
                <div class="top-light"></div>
                <h1 class="glow-text">${data.name}</h1>
                <div class="bottom-light"></div>
            </div>
            <div class="doorway">
                <img src="images/${data.img}" alt="${data.name}">
            </div>
        </div>
    `).join('');

    container.innerHTML = htmlContent;
}
//生成2F店面
function renderShops2F(containerId) {
    const count = 7;
    const imgPrefix = "shop2F_";
    const imgMaxIndex = 6;

    const container = document.getElementById(containerId);
    if (!container) return;

    let htmlContent = "";
    let lastIndex = -1; // 用來記錄上一個圖片的索引，初始值設為 -1

    for (let i = 0; i < count; i++) {
        let randomIndex;

        // 迴圈：只要抽到的數字跟上次一樣，就一直抽，直到不一樣為止
        do {
            randomIndex = Math.floor(Math.random() * (imgMaxIndex + 1));
        } while (randomIndex == lastIndex);

        // 更新 lastIndex 為當前抽到的值
        lastIndex = randomIndex;

        htmlContent += `
            <div class="shop">
                <div class="doorway">
                    <img src="/images/${imgPrefix}${randomIndex}.webp" alt="Shop Image">
                </div>
            </div>
        `;
    }

    container.innerHTML = htmlContent;
}
