<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;700&display=swap" rel="stylesheet">
    <title>ธรรมะจรรโลงใจ - ทศพิธราชธรรม</title>
    <style>
        :root {
            --primary-brown: #8B4513;
            --dark-brown: #5d2e0a;
            --zen-bg: #fdf5e6;
        }

        body {
            background-color: var(--zen-bg);
            font-family: 'Sarabun', sans-serif;
            margin: 0;
            color: #333;
            overflow-x: hidden;
        }

        /* Header */
        header h1.box {
            color: white;
            background: linear-gradient(135deg, #2c3e50, #000000);
            padding: 25px;
            margin: 0;
            transition: 0.5s;
            font-weight: bold;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            text-align: center;
        }

        header h1.box:hover {
            background: var(--primary-brown);
            letter-spacing: 2px;
        }

        /* Tree & Image Container */
        .tree-container {
            position: relative;
            width: 100%;
            max-width: 1000px;
            margin: 20px auto;
            aspect-ratio: 16 / 9;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            overflow: hidden;
        }

        .img-16-9 {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        /* Leaf Style */
        .leaf-wrapper {
            position: absolute;
            z-index: 100;
            cursor: pointer;
            transition: transform 0.3s ease;
            width: 7%;
            min-width: 40px;
        }

        .leaf-wrapper:hover {
            transform: scale(1.3) rotate(10deg);
            z-index: 101;
        }

        .leaf-img {
            width: 100%;
            transition: filter 0.3s ease;
            filter: drop-shadow(0 0 5px rgba(0, 0, 0, 0.3));
            animation: sway 4s infinite ease-in-out;
            transform-origin: top center;
        }

        .leaf-wrapper:hover .leaf-img {
            filter: drop-shadow(0 0 15px rgba(255, 215, 0, 0.8)) drop-shadow(0 0 25px rgba(255, 223, 0, 0.5));
        }

        @keyframes sway {
            0%, 100% { transform: rotate(-5deg); }
            50% { transform: rotate(5deg); }
        }

        .leaf-fall-animation {
            animation: leafFall 2.5s forwards ease-in !important;
            pointer-events: none;
        }

        @keyframes leafFall {
            0% { transform: translateY(0) rotate(0deg); opacity: 1; }
            100% { transform: translateY(600px) rotate(720deg); opacity: 0; }
        }

        /* Modal */
        .custom-modal {
            display: none;
            position: fixed;
            z-index: 2000;
            left: 0; top: 0;
            width: 100%; height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(5px);
            align-items: center;
            justify-content: center;
        }

        .modal-card {
            background: white;
            padding: 40px;
            width: 90%;
            max-width: 500px;
            border-radius: 30px;
            text-align: center;
            border-bottom: 8px solid var(--primary-brown);
            animation: popIn 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        @keyframes popIn {
            from { transform: scale(0.8); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }

        .close-btn {
            background: var(--primary-brown);
            color: white;
            border: none;
            padding: 10px 40px;
            border-radius: 50px;
            margin-top: 20px;
            font-weight: bold;
            transition: 0.3s;
        }

        .badge-num {
            background: var(--primary-brown);
            color: white;
            width: 30px; height: 30px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.9rem; flex-shrink: 0;
        }

        /* Falling Leaves Background */
        .falling-leaf {
            position: fixed;
            top: -50px;
            z-index: 9999;
            pointer-events: none;
            opacity: 0.2;
            animation-iteration-count: infinite;
            animation-timing-function: linear;
        }

        @keyframes fall {
            0% { transform: translateY(0vh) rotate(0deg); opacity: 0.8; }
            100% { transform: translateY(110vh) rotate(720deg); opacity: 0; }
        }

        .audio-control {
            position: fixed;
            bottom: 20px; right: 20px;
            z-index: 10000;
            background: var(--primary-brown);
            color: white;
            border: 2px solid #fff;
            border-radius: 50%;
            width: 50px; height: 50px;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            display: flex; align-items: center; justify-content: center;
        }
    </style>
</head>

<body>
    <?php 
        $dharma_list = [
            ["title" => "ทาน", "desc" => "การให้และแบ่งปันสิ่งของแก่ผู้อื่น"],
            ["title" => "ศีล", "desc" => "ความประพฤติดีงามทางกายและวาจา"],
            ["title" => "บริจาค", "desc" => "การเสียสละความสุขส่วนตนเพื่อส่วนรวม"],
            ["title" => "อาชชวะ", "desc" => "ความซื่อตรงและความจริงใจ"],
            ["title" => "มัททวะ", "desc" => "ความอ่อนโยนและมีสัมมาคารวะ"],
            ["title" => "ตบะ", "desc" => "ความเพียรพยายามไม่ย่อท้อ"],
            ["title" => "อักโกธะ", "desc" => "ความไม่โกรธและรู้จักให้อภัย"],
            ["title" => "อวิหิงสา", "desc" => "ความไม่เบียดเบียนผู้อื่น"],
            ["title" => "ขันติ", "desc" => "ความอดทนต่ออุปสรรคทั้งปวง"],
            ["title" => "อวิโรธนะ", "desc" => "ความหนักแน่นมั่นคงในความถูกต้อง"]
        ];
        $header_title = "ธรรมะสอนใจ";
    ?>

    <button id="musicToggle" class="audio-control" onclick="toggleMusic()">
        <span id="musicIcon" class="audio-icon">🔇</span>
    </button>

    <header class="text-center">
        <h1 class="box"><?php echo $header_title; ?></h1>
        <p class="mt-3">เลือกคลิกที่ <b>ใบโพธิ์ทอง</b> เพื่อศึกษาหลักธรรม</p>
    </header>

    <div class="tree-container" id="mainContainer">
        <img src="buddha-bg2.png" class="img-16-9" alt="Buddha Background">

        <div class="leaf-wrapper" style="top: 1%; left: 25%;" onclick="openLeaf(this, 'ทาน', 'การสละทรัพย์สิ่งของเพื่อช่วยเหลือผู้อื่น')">
            <img src="gold leaf ver 2.png" class="leaf-img">
        </div>
        <div class="leaf-wrapper" style="top: 1%; left: 35%;" onclick="openLeaf(this, 'ศีล', 'การรักษากาย วาจา ให้บริสุทธิ์')">
            <img src="gold leaf ver 2.png" class="leaf-img">
        </div>
        <div class="leaf-wrapper" style="top: 1%; left: 55%;" onclick="openLeaf(this, 'บริจาค', 'การเสียสละความสุขส่วนตน')">
            <img src="gold leaf ver 2.png" class="leaf-img">
        </div>
         <div class="leaf-wrapper" style="top: 1%; left: 15%;" onclick="openLeaf(this, 'อาชชวะ', 'ความซื่อตรงและความจริงใจ')">
            <img src="gold leaf ver 2.png" class="leaf-img">
        </div>
         <div class="leaf-wrapper" style="top: 1%; left: 5%;" onclick="openLeaf(this, 'มัททวะ', 'ความอ่อนโยนและมีสัมมาคารวะ')">
            <img src="gold leaf ver 2.png" class="leaf-img">
        </div>
         <div class="leaf-wrapper" style="top: 1%; left: 85%;" onclick="openLeaf(this, 'ตบะ', 'ความเพียรพยายามไม่ย่อท้อ')">
            <img src="gold leaf ver 2.png" class="leaf-img">
        </div>
         <div class="leaf-wrapper" style="top: 1%; left: 95%;" onclick="openLeaf(this, 'อักโกธะ', 'ความไม่โกรธและรู้จักให้อภัย')">
            <img src="gold leaf ver 2.png" class="leaf-img">
        </div>
         <div class="leaf-wrapper" style="top: 1%; left: 75%;" onclick="openLeaf(this, 'อวิหิงสา', 'ความไม่เบียดเบียนผู้อื่น')">
            <img src="gold leaf ver 2.png" class="leaf-img">
        </div>
         <div class="leaf-wrapper" style="top: 1%; left: 50%;" onclick="openLeaf(this, 'ขันติ', 'ความอดทนต่ออุปสรรคทั้งปวง')">
            <img src="gold leaf ver 2.png" class="leaf-img">
        </div>
         <div class="leaf-wrapper" style="top: 1%; left: 20%;" onclick="openLeaf(this, 'อวิโรธนะ', 'ความหนักแน่นมั่นคงในความถูกต้อง')">
            <img src="gold leaf ver 2.png" class="leaf-img">
        </div>
</div>

    <div class="container my-5">
        <div class="card p-4 shadow-sm" style="border-radius: 20px;">
            <h4 class="mb-4" style="color: var(--primary-brown);">สรุปหลักทศพิธราชธรรม</h4>
            <div class="row g-3">
                <?php foreach ($dharma_list as $index => $item): ?>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center p-2 border-bottom">
                            <div class="badge-num me-3"><?php echo ($index + 1); ?></div>
                            <div>
                                <strong><?php echo $item['title']; ?></strong>: 
                                <span class="text-muted"><?php echo $item['desc']; ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div id="infoModal" class="custom-modal">
        <div class="modal-card">
            <h2 id="modalTitle" style="color: var(--primary-brown);"></h2>
            <hr>
            <p id="modalBody" class="fs-5"></p>
            <button class="close-btn" onclick="closeModal()">ปิดหน้าต่าง</button>
        </div>
    </div>

    <audio id="myAudio" loop><source src="YlangYlang.mp3" type="audio/mpeg"></audio>

    <script>
        function openLeaf(element, title, desc) {
            document.getElementById('modalTitle').innerText = title;
            document.getElementById('modalBody').innerText = desc;
            document.getElementById('infoModal').style.display = 'flex';
            element.classList.add('leaf-fall-animation');
            playMusic();
        }

        function closeModal() { document.getElementById('infoModal').style.display = 'none'; }

        // ระบบใบไม้ร่วงพื้นหลัง
        function createFallingLeaf() {
            const leaf = document.createElement('img');
            leaf.src = 'gold leaf ver 2.png';
            leaf.classList.add('falling-leaf');
            leaf.style.left = Math.random() * 100 + 'vw';
            const size = Math.random() * 20 + 20;
            leaf.style.width = size + 'px';
            const duration = Math.random() * 5 + 5;
            leaf.style.animation = `fall ${duration}s linear infinite`;
            document.body.appendChild(leaf);
            setTimeout(() => { leaf.remove(); }, duration * 1000);
        }
        setInterval(createFallingLeaf, 2000);

        // ระบบเสียง
        const audio = document.getElementById("myAudio");
        const icon = document.getElementById("musicIcon");

        function playMusic() {
            audio.play().then(() => { icon.innerText = "🔊"; }).catch(e => console.log("Click to play"));
        }

        function toggleMusic() {
            if (audio.paused) { audio.play(); icon.innerText = "🔊"; }
            else { audio.pause(); icon.innerText = "🔇"; }
        }

        window.onclick = function(event) {
            if (event.target == document.getElementById('infoModal')) closeModal();
        }
    </script>
</body>
</html>
