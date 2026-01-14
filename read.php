<?php
// --- 1. データベース接続 ---
try {
    $pdo = new PDO('mysql:dbname=atora_db_260102;charset=utf8mb4;host=localhost', 'root', '');
} catch (PDOException $e) {
    exit('DB接続エラー:' . $e->getMessage());
}

// --- 2. ユーザーの最新の悩みを取得 ---
$stmt_p = $pdo->prepare("SELECT * FROM archive_table ORDER BY created_at DESC LIMIT 1");
$stmt_p->execute();
$latest = $stmt_p->fetch(PDO::FETCH_ASSOC);

// --- 3. 賢人のルートデータを全件取得 ---
$stmt_s = $pdo->prepare("SELECT * FROM sage_routes");
$stmt_s->execute();
$all_routes = $stmt_s->fetchAll(PDO::FETCH_ASSOC);

// --- 4. 悩みに基づく並び替え ---
$user_pain = $latest['pain_point'] ?? '';
$priority_routes = [];
$other_routes = [];

foreach ($all_routes as $route) {
    if (!empty($user_pain) && mb_strpos($user_pain, $route['experience_type']) !== false) {
        $priority_routes[] = $route;
    } else {
        $other_routes[] = $route;
    }
}
$final_routes = array_merge($priority_routes, $other_routes);
$json_routes = json_encode($final_routes, JSON_UNESCAPED_UNICODE);

function h($str) { return htmlspecialchars($str, ENT_QUOTES, 'UTF-8'); }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atora | Path of Sages</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400&family=Noto+Serif+JP:wght@200;300;400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css?v=5">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        /* JS版の静寂な空気感を取り戻すためのスタイル再定義 */
        body { 
            display: block !important;
            height: auto !important;
            overflow-y: auto !important;
            background-color: var(--bg-color) !important;
            margin: 0; padding: 0;
            font-family: 'Noto Serif JP', serif; /* メインを明朝体に固定 */
            -webkit-font-smoothing: antialiased;
        }

        .wrapper-read { width: 100%; padding-top: 140px; display: flex; flex-direction: column; align-items: center; }
        
        /* 悩み表示セクション：文字間隔とウェイトをJS版に統一 */
        .recall-section { text-align: center; margin-bottom: 120px; padding: 0 20px; }
        .recall-sub { font-family: 'Montserrat', sans-serif; font-size: 0.65rem; letter-spacing: 0.6em; color: #b0b0b0; margin-bottom: 25px; text-transform: uppercase; font-weight: 300; }
        .recall-text { font-weight: 200; font-size: 1.6rem; color: #1a1a1a; letter-spacing: 0.2em; line-height: 2.2; }

        #map { 
            height: 600px !important; width: 100vw !important; margin: 60px 0 120px 0;
            filter: grayscale(1) contrast(0.9) brightness(1.02);
            border-top: 0.5px solid #eaeaea; border-bottom: 0.5px solid #eaeaea; z-index: 1;
            position: relative; left: 50%; transform: translateX(-50%);
        }

        /* グリッドカード：余白とフォントサイズを以前の通りに固定 */
        .content-container { max-width: 960px; margin: 0 auto; padding: 0 40px; }
        .top-label { font-family: 'Montserrat', sans-serif; font-size: 0.65rem; letter-spacing: 0.5em; color: #ccc; text-transform: uppercase; margin-bottom: 80px; }
        
        .route-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 80px 60px; text-align: left; }
        .route-card { padding-top: 40px; border-top: 0.4px solid #eee; cursor: pointer; transition: 0.4s ease; }
        .route-card:hover { opacity: 0.5; }
        
        .route-tag { font-family: 'Montserrat', sans-serif; font-size: 0.55rem; letter-spacing: 0.35em; color: #bbb; margin-bottom: 20px; display: block; text-transform: uppercase; font-weight: 300; }
        .route-title { font-size: 1.15rem; font-weight: 300; margin-bottom: 20px; letter-spacing: 0.12em; color: #1a1a1a; line-height: 1.6; }
        .route-desc { font-size: 0.85rem; line-height: 2.4; color: #777; font-weight: 300; letter-spacing: 0.05em; }

        /* モーダル：JS版の詳細デザインを再現 */
        #modal_overlay { transition: opacity 0.8s ease, visibility 0.8s; visibility: hidden; display: flex; opacity: 0; }
        #modal_overlay.active { opacity: 1 !important; visibility: visible; }
        .modal-content { padding: 80px 60px; max-width: 800px; border-radius: 0; }
        .modal-tag { font-family: 'Montserrat', sans-serif; font-size: 0.6rem; letter-spacing: 0.4em; color: #aaa; margin-bottom: 30px; }
        .story-text { font-size: 0.95rem; line-height: 2.8; color: #555; margin-bottom: 60px; font-weight: 300; }
        
        .experience-hint h3 { font-family: 'Montserrat', sans-serif; letter-spacing: 0.4em; font-size: 0.65rem; color: #999; border-bottom: none; margin-bottom: 20px; }
        #modal_hint { font-size: 0.85rem; line-height: 2.4; color: #666; font-family: 'Noto Serif JP', serif; }

        @media (max-width: 768px) { .route-grid { grid-template-columns: 1fr; gap: 60px; } }
    </style>
</head>
<body>

<div class="wrapper-read fade-in">
    <div class="recall-section">
        <p class="recall-sub">User Perspective</p>
        <p class="recall-text">「<?= h($latest['pain_point'] ?? '旅の目的を探す') ?>」</p>
    </div>

    <div id="map"></div>

    <div class="content-container">
        <div class="top-label">Recommended Archives for your theme</div>
        <div id="route_list" class="route-grid"></div>
        <footer style="margin: 160px 0 100px;">
            <a href="input.php" style="font-family: 'Montserrat'; font-size: 0.6rem; letter-spacing: 0.5em; color: #ccc; text-decoration: none; border-bottom: 0.5px solid #eee; padding-bottom: 12px; font-weight: 300;">RETURN TO ORIGIN</a>
        </footer>
    </div>
</div>

<div id="modal_overlay" class="modal-overlay">
    <div class="modal-content fade-in">
        <div class="close-btn" onclick="closeModal()">×</div>
        <p class="modal-tag" id="modal_tag"></p>
        <h2 id="modal_title" style="font-weight: 300; font-size: 1.8rem; letter-spacing: 0.15em; margin-bottom: 40px;"></h2>
        <div class="story-text" id="modal_desc"></div>
        <div class="experience-hint">
            <h3>RECOMMENDED ROUTE</h3>
            <p id="modal_hint"></p>
        </div>
        <button class="btn-plan" onclick="closeModal()" style="margin-top: 60px; background: none; color: #bbb; border: 0.5px solid #eee; font-family: 'Montserrat'; letter-spacing: 0.3em; font-size: 0.6rem;">CLOSE</button>
    </div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    const sageData = <?php echo $json_routes; ?>;
    const map = L.map('map', { zoomControl: false, scrollWheelZoom: false }).setView([36.2, 138.2], 5);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
    setTimeout(() => { map.invalidateSize(); }, 400);

    const routeList = document.getElementById('route_list');

    if (sageData.length > 0) {
        sageData.forEach(route => {
            const marker = L.circleMarker([route.lat, route.lng], {
                radius: 6, color: '#000', weight: 0.4, fillColor: '#000', fillOpacity: 0.8
            }).addTo(map);

            marker.on('click', () => openModal(route));

            const card = document.createElement('div');
            card.className = 'route-card';
            card.innerHTML = `
                <span class="route-tag">${route.experience_type} / ${route.name}</span>
                <h2 class="route-title">${route.location_name}</h2>
                <p class="route-desc">${route.description}</p>
            `;
            card.onclick = () => openModal(route);
            routeList.appendChild(card);
        });
    }

    function openModal(data) {
        document.getElementById('modal_tag').innerText = `${data.experience_type} / ${data.name}`;
        document.getElementById('modal_title').innerText = data.location_name;
        document.getElementById('modal_desc').innerText = data.description;
        document.getElementById('modal_hint').innerText = data.recommended_route || "静寂と共に、その地を歩む。";
        document.getElementById('modal_overlay').classList.add('active');
        map.flyTo([data.lat, data.lng], 9, { duration: 2.0, easeLinearity: 0.1 });
    }

    function closeModal() {
        document.getElementById('modal_overlay').classList.remove('active');
    }
</script>
</body>
</html>