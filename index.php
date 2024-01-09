<?php
$jsonData = [
    'lang'     => 'sk',
    'title'    => 'Book player',
    'subtitle' => null,
];
if (file_exists('metadata/page.json')) {
    $jsonData = json_decode(file_get_contents('metadata/page.json'), true);
}
?>
    <!DOCTYPE html>
    <html lang="<?= $jsonData['lang'] ?>">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
        <title><?= $jsonData['title'] ?></title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400&family=Roboto+Mono:wght@100;200&display=swap"
              rel="stylesheet">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
              integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
              crossorigin="anonymous" referrerpolicy="no-referrer"/>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js"
                integrity="sha512-GWzVrcGlo0TxTRvz9ttioyYJ+Wwk9Ck0G81D+eO63BaqHaJ3YZX9wuqjwgfcV/MrB2PhaVX9DkYVhbFpStnqpQ=="
                crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <link rel="shortcut icon"
              href="data:image/svg+xml,%3Csvg version='1.0' id='Layer_1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 64 64' enable-background='new 0 0 64 64' xml:space='preserve' fill='%23000000'%3E%3Cg id='SVGRepo_bgCarrier' stroke-width='0'%3E%3C/g%3E%3Cg id='SVGRepo_tracerCarrier' stroke-linecap='round' stroke-linejoin='round'%3E%3C/g%3E%3Cg id='SVGRepo_iconCarrier'%3E%3Cg%3E%3Cpath fill='%23F9EBB2' d='M56,62H10c-2.209,0-4-1.791-4-4s1.791-4,4-4h46V62z'%3E%3C/path%3E%3Cg%3E%3Cpath fill='%2345AAB8' d='M6,4v49.537C7.062,52.584,8.461,52,10,52h2V2H8C6.896,2,6,2.896,6,4z'%3E%3C/path%3E%3Cpath fill='%2345AAB8' d='M56,2H14v50h42h2v-2V4C58,2.896,57.104,2,56,2z'%3E%3C/path%3E%3C/g%3E%3Cg%3E%3Cpath fill='%23394240' d='M60,52V4c0-2.211-1.789-4-4-4H8C5.789,0,4,1.789,4,4v54c0,3.313,2.687,6,6,6h49c0.553,0,1-0.447,1-1 s-0.447-1-1-1h-1v-8C59.104,54,60,53.104,60,52z M6,4c0-1.104,0.896-2,2-2h4v50h-2c-1.539,0-2.938,0.584-4,1.537V4z M56,62H10 c-2.209,0-4-1.791-4-4s1.791-4,4-4h46V62z M56,52H14V2h42c1.104,0,2,0.896,2,2v46v2H56z'%3E%3C/path%3E%3Cpath fill='%23394240' d='M43,26H23c-0.553,0-1,0.447-1,1s0.447,1,1,1h20c0.553,0,1-0.447,1-1S43.553,26,43,26z'%3E%3C/path%3E%3Cpath fill='%23394240' d='M49,20H23c-0.553,0-1,0.447-1,1s0.447,1,1,1h26c0.553,0,1-0.447,1-1S49.553,20,49,20z'%3E%3C/path%3E%3Cpath fill='%23394240' d='M23,16h12c0.553,0,1-0.447,1-1s-0.447-1-1-1H23c-0.553,0-1,0.447-1,1S22.447,16,23,16z'%3E%3C/path%3E%3C/g%3E%3Cpath opacity='0.2' fill='%23231F20' d='M6,4v49.537C7.062,52.584,8.461,52,10,52h2V2H8C6.896,2,6,2.896,6,4z'%3E%3C/path%3E%3C/g%3E%3C/g%3E%3C/svg%3E">
        <style>
            body {
                background-color : #121212;
                color            : #ffffff;
                font-family      : 'Poppins', sans-serif;
                margin           : 0;
                padding          : 0;
                height           : 100vh;
                transition       : all 0.5s ease;
                max-width        : 100vw;
            }

            body.light-mode {
                background-color : #ffffff !important;
                color            : #121212 !important;
            }

            .main-container {
                display         : flex;
                flex-direction  : column;
                justify-content : center;
                align-items     : center;
                height          : 100%;
            }

            .page-title {
                text-align    : center;
                color         : #f8f9fa;
                font-size     : 1.8em;
                font-weight   : 400;
                margin-bottom : 10px;
            }

            .page-subtitle {
                text-align    : center;
                color         : #adb5bd;
                font-size     : 1.2em;
                margin-bottom : 20px;
                font-weight   : 300;
            }

            .light-mode .page-title {
                color : #121212;
            }

            .light-mode .page-subtitle {
                color : #121212;
            }

            .mp3-container {
                /*width            : 95%;*/
                max-width        : min(600px, 100vw);
                background-color : #1e1e1e;
                border-radius    : 10px;
                padding          : 20px;
                box-shadow       : 0 4px 8px rgba(0, 0, 0, 0.2);
            }

            .mp3-item {
                position         : relative;
                background-color : #242424;
                padding          : 10px;
                border-radius    : 5px;
                margin-bottom    : 15px;
                transition       : all 0.3s ease;
            }

            .mp3-item:hover {
                background-color : #2a2a2a;
            }

            .mp3-title {
                margin-bottom : 5px;
            }

            .light-mode .mp3-title {
                color : white;
            }

            .mp3-controls {
                display         : flex;
                align-items     : center;
                justify-content : space-between;
            }

            button {
                background-color : #007bff;
                border           : none;
                color            : white;
                padding          : 5px 10px;
                border-radius    : 5px;
                cursor           : pointer;
                transition       : background-color 0.3s ease;
            }

            button:hover {
                background-color : #0056b3;
            }

            .progress-bar {
                margin-left      : 10px;
                width            : 55%;
                background-color : #333333;
                border-radius    : 5px;
                overflow         : hidden;
            }

            .progress-bar-inner {
                height           : 10px;
                background-color : #007bff;
                width            : 0;
            }

            @media (max-width : 600px) {
                .main-container {
                    display : block;
                }

                .mp3-container {
                    border-radius : 0;
                }

                .mp3-controls {
                    flex-direction : column;
                    align-items    : stretch;
                }

                .progress-bar {
                    width  : 100%;
                    margin : 25px 0;
                }

                .time-info {
                    text-align : center;
                }
            }

            .time-info {
                margin-left : 10px;
                color       : #a1a1a1;
                font-size   : 0.9em;
                font-family : 'Roboto Mono', monospace;
            }

            .expand-caret {
                cursor : pointer;
            }

            .mp3-description {
                max-height : 0;
                transition : max-height 200ms ease-out;
                margin-top : 0.5em;
                font-size  : 0.9em;
                color      : #888;
                overflow   : hidden;
            }

            .description-opened {
                max-height : 500px;
                transition : max-height 200ms ease-in;
            }

            .settings-icon {
                position : absolute;
                top      : 15px;
                right    : 15px;
                width    : 50px;
                height   : 50px;
                cursor   : pointer;
                fill     : #ffffff;
                stroke   : #ffffff;
            }

            .light-mode .settings-icon {
                fill   : #000000;
                stroke : #000000;
            }

            /* The Modal for dark mode */
            body .settings-modal {
                position         : fixed;
                left             : 0;
                right            : 0;
                top              : 0;
                bottom           : 0;
                background-color : #2c2c2c;
                display          : flex;
                align-items      : center;
                justify-content  : center;
            }

            body.light-mode .settings-modal {
                background-color : rgba(0, 0, 0, 0.4);
            }

            /* Modal Content */
            body .settings-modal-content {
                background-color : #2c2c2c;
                color            : white;
                border           : none;
                border-radius    : 5px;
                box-shadow       : 0 5px 15px rgba(0, 0, 0, 0.3);
                width            : 90%;
                max-width        : 500px;
                padding          : 40px;
                text-align       : center;
            }

            body.light-mode .settings-modal-content {
                background-color : #f4f4f4;
                color            : #121212;
            }

            /* The Close Button */
            body .close {
                color       : white;
                position    : absolute;
                top         : 20px;
                right       : 30px;
                font-size   : 25px;
                font-weight : bold;
            }

            body .close:hover,
            body .close:focus {
                color           : #999;
                text-decoration : none;
                cursor          : pointer;
            }

            body.light-mode .close {
                color : #121212;
            }

            body.light-mode .close:hover,
            body.light-mode .close:focus {
                color : #444;
            }

            /* Settings Toggle Button Styles */
            button {
                background-color : #007bff;
                border           : none;
                color            : white;
                text-align       : center;
                text-decoration  : none;
                display          : inline-block;
                font-size        : 16px;
                margin           : 10px 2px;
                cursor           : pointer;
                padding          : 12px 24px;
                border-radius    : 5px;
                transition       : background 0.3s ease;
            }

            button:hover {
                background : #0056b3;
            }

            /* Volume Control Slider Styles */
            input[type=range] {
                width         : 100%;
                height        : 25px;
                background    : #333;
                outline       : none;
                opacity       : 0.7;
                transition    : opacity .2s;
                border-radius : 5px;
            }

            input[type=range]:hover {
                opacity : 1;
            }

            input[type=range]::-webkit-slider-thumb {
                -webkit-appearance : none;
                appearance         : none;
                width              : 25px;
                height             : 25px;
                background         : #007bff;
                cursor             : pointer;
                border-radius      : 50%;
            }

            input[type=range]::-webkit-slider-thumb:hover {
                background : #0056b3;
            }

            input[type=range]::-moz-range-thumb {
                width         : 25px;
                height        : 25px;
                background    : #007bff;
                cursor        : pointer;
                border-radius : 50%;
            }

            .mp3-item.listened {
                color : #adb5bd; /* Muted text color */
            }

            .mp3-item.listened .expand-caret {
                display : none;
            }

            .mp3-item.listened .mp3-controls,
            .mp3-item.listened .mp3-description {
                display : none; /* Hide controls and description for listened items */
            }

            .mp3-item .mark-listened,
            .mp3-item .mark-not-listened {
                position         : absolute;
                top              : 10px;
                right            : 10px;
                border           : none;
                background-color : transparent;
                color            : #fff; /* or any color that fits your design */
                opacity          : 0.5;
                cursor           : pointer;
                font-size        : 16px; /* Adjust size as needed */
                padding          : 5px;
                border-radius    : 50%;
                margin           : 0;
                height           : 28px;
                width            : 28px;
            }

            .mp3-item .mark-listened:hover,
            .mp3-item .mark-not-listened:hover {
                opacity : 1;
            }
        </style>
    </head>
    <body>
    <div class="settings-modal" id="settingsModal" style="display: none;">
        <div class="settings-modal-content">
            <span class="close">&times;</span>

            <h2>Settings</h2>
            <!--            <button onclick="toggleDarkMode()">Toggle Dark Mode</button>-->

            <label for="volumeControl">Volume control:</label>
            <input type="range" min="0" max="100" value="100" class="slider" id="volumeControl">
        </div>
    </div>

    <svg class="settings-icon" id="settings-icon" version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
         onclick="window.openModal()">
        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
        <g id="SVGRepo_iconCarrier">
            <g>
                <line fill="none" y1="501" x1="303.1" y2="501" x2="302.1"></line>
                <g>
                    <path d="m501,300.8v-91.7h-45.3c-5.3-22.4-14.3-43.3-26.4-62.1l32.9-32.7-64.9-64.6-33.4,33.3c-18.8-11.5-39.6-19.9-61.8-24.8v-47.2h-92.1v48.3c-22,5.4-42.6,14.4-61.1,26.4l-34.2-34-64.9,64.6 35.3,35.2c-2.8,4.6-5.3,9.2-7.7,14-7.5,14.3-13.2,30-17.1,45.7h-49.3v91.7h50.3c1.5,6 3.3,11.9 5.3,17.8 0.1,0.4 0.3,0.8 0.4,1.2 0,0.1 0.1,0.2 0.1,0.4 4.9,14.2 11.3,27.7 19.1,40.2l-35.5,35.3 64.9,64.6 35.1-34.9c18.3,11.5 38.6,20.2 60.2,25.4v48.1h91.1v-47.1c22.7-5 44-13.7 63.1-25.6l32.2,32 64.9-64.6-32.1-31.9c12-19.1 20.9-40.3 26-62.9h44.9zm-94.8,64l29.9,29.8-36.6,36.5-29.5-29.4c-24.7,18.9-54.4,31.7-86.7,36v42.4h-51.3v-42.7c-31.5-4.6-60.4-17.2-84.6-35.7l-31.6,31.5-36.6-36.5 32.4-31.3c-17.9-24-30-52.4-34.4-83.4h-45.3v-51.1h44l1.5-3.6c4.7-29.7 16.5-57.1 33.6-80.3l-32-31.9 36.6-36.5 31,31.9c24-18.5 52.8-31.2 84.1-36v-42.7h51.3v42.3c32,4.1 61.3,16.4 86,34.8l30.3-30.1 35.6,36.5-29.6,29.5c18.2,23.8 30.7,52.2 35.5,83.1h45.4v51.1h-44.7c-3.9,31.8-16.1,61.1-34.3,85.8z"></path>
                    <path d="m257,143.4c-61.8,0-113.1,50-113.1,112.6s51.4,112.6 113.1,112.6 113.1-51.1 113.1-112.6-51.3-112.6-113.1-112.6zm0,204.3c-51.3,0-92.1-40.7-92.1-91.7 0-51.1 41.9-91.7 92.1-91.7s92.1,40.7 92.1,91.7c0.1,51.1-41.8,91.7-92.1,91.7z"></path>
                </g>
            </g>
        </g>
    </svg>


    <div class="main-container">
        <?php if (isset($jsonData['title'])): ?>
            <h1 class="page-title"><?= $jsonData['title'] ?></h1>
        <?php endif; ?>

        <?php if (isset($jsonData['subtitle'])): ?>
            <p class="page-subtitle"><?= $jsonData['subtitle'] ?></p>
        <?php endif; ?>
        <div class="mp3-container">
            <?php

            function getMP3Duration($filename)
            {
                return MpegAudio::fromFile($filename)->getTotalDuration();
            }


            function getMD5Hash($filename)
            {
                return md5_file($filename);
            }

            function getMP3Details($filename)
            {
                if (!is_dir('metadata')) {
                    mkdir('metadata');
                }
                $hash         = getMD5Hash($filename);
                $jsonFilename = 'metadata/' . pathinfo($filename, PATHINFO_FILENAME) . '.json';
                $fileSize     = filesize($filename);

                if (file_exists($jsonFilename)) {
                    $jsonData = json_decode(file_get_contents($jsonFilename), true);

                    // Check if hash matches and duration is present
                    if (isset($jsonData['hash']) && $jsonData['hash'] === $hash && isset($jsonData['duration'])) {
                        return $jsonData; // Use the stored duration
                    }

                    // Hash mismatch or duration not present, regenerate JSON
                    rename($jsonFilename, $filename . '-old.json');
                }

                // JSON does not exist or hash mismatch, calculate duration
                $durationInSeconds = getMP3Duration($filename);

                // Create new JSON data
                $newJsonData = [
                    'name'     => $filename,
                    'size'     => $fileSize,
                    'hash'     => $hash,
                    'duration' => $durationInSeconds,
                ];

                // Preserve additional data if old JSON exists
                if (isset($jsonData) && is_array($jsonData)) {
                    foreach ($jsonData as $key => $value) {
                        if (!in_array($key, ['name', 'size', 'hash', 'duration'])) {
                            $newJsonData[$key] = $value;
                        }
                    }
                }

                file_put_contents($jsonFilename, json_encode($newJsonData));
                if (file_exists($filename . '-old.json')) {
                    unlink($filename . '-old.json'); // Delete old JSON file
                }

                return $newJsonData;
            }

            $files = glob("*.mp3");
            natsort($files);
            foreach ($files as $file) {
                $encodedFile  = rawurlencode($file);
                $fileJsonData = getMP3Details($file); // Get details including duration

                $duration    = $fileJsonData['duration'];
                $hash        = $fileJsonData['hash'];
                $title       = isset($fileJsonData['title']) ? $fileJsonData['title'] : htmlspecialchars($file);
                $description = isset($fileJsonData['description']) ? $fileJsonData['description'] : null;

                // Convert duration to minutes and seconds format
                $minutes = floor($duration / 60);
                $seconds = str_pad((int)$duration % 60, 2, "0", STR_PAD_LEFT);

                $formattedDuration = sprintf("%02d:%02d", $minutes, $seconds);

                echo '<div class="mp3-item" id="item-' . $hash . '" data-filename="' . $encodedFile . '" data-duration="' . $formattedDuration . '">';
                echo '<button title="Mark as listened to" class="mark-listened" onclick="markAsListened(\'' . $hash . '\')"><i class="fa-solid fa-file-audio"></i></button>
                      <button title="Mark as not listened to" class="mark-not-listened" onclick="markAsNotListened(\'' . $hash . '\')" style="display:none;"><i class="fa-regular fa-file-audio"></i></button>';
                echo '<div class="mp3-title" onclick="toggleDescription(\'' . $hash . '\')" >' . $title;
                if (!is_null($description)) {
                    echo ' <span class="expand-caret caret-' . $hash . '" onclick="toggleDescription(\'' . $hash . '\')">&#9660;</span>';
                }
                echo '</div>';
                echo '<div class="mp3-controls">';
                echo '<button onclick="playAudio(\'' . $hash . '\')">Play</button>';
                echo '<div class="progress-bar" onclick="seekAudio(event, \'' . $hash . '\')"><div class="progress-bar-inner"></div></div>';
                echo '<div class="time-info">00:00 / ' . $formattedDuration . '</div>'; // Use the formatted duration here
                echo '</div>';
                if (!is_null($description)) {
                    echo '<div class="mp3-description" onclick="toggleDescription(\'' . $hash . '\')" id="desc-' . $hash . '">' . htmlspecialchars($description) . '</div>';
                }
                echo '<audio preload="metadata" onloadedmetadata="updateTimeInfo(\'' . $hash . '\')" ontimeupdate="updateProgress(\'' . $hash . '\')" id="audio-' . $hash . '"></audio>';
                echo '</div>';
            }

            ?>
        </div>
    </div>

    <script>
        let currentAudio = null;
        let currentButton = null;

        function toggleDescription(hash) {
            let descElement = document.getElementById('desc-' + hash);
            descElement.classList.toggle('description-opened');
        }

        function formatTime(seconds) {
            let hours = Math.floor(seconds / 3600);
            let minutes = Math.floor((seconds % 3600) / 60);
            let secs = Math.floor(seconds % 60);
            return [hours, minutes, secs]
                .map(v => v < 10 ? '0' + v : v)
                .filter((v, i) => v !== '00' || i > 0)
                .join(':');
        }

        function playAudio(hash) {
            // Selecting elements based on the passed hash
            let itemElement = document.getElementById('item-' + hash);
            let encodedFilename = itemElement.dataset.filename;
            let audioElement = document.getElementById('audio-' + hash);
            let playButton = itemElement.querySelector('button');

            // Error handling for missing elements
            if (!itemElement) {
                console.error('Item element not found for:', encodedFilename);
                return;
            }
            if (!audioElement) {
                console.error('Audio element not found for:', encodedFilename);
                return;
            }
            if (!playButton) {
                console.error('Play button not found for:', encodedFilename);
                return;
            }

            // Assign file source to the audio element if not already set
            if (!audioElement.src) {
                audioElement.src = decodeURIComponent(encodedFilename);
            }

            // Fetch progress and set currentTime from localStorage
            if (localStorage.getItem(hash + '-time')) {
                let progress = document.querySelector('#item-' + hash + ' .progress-bar-inner');
                let percentage = localStorage.getItem(hash + '-progress');
                progress.style.width = percentage + '%';
                audioElement.currentTime = localStorage.getItem(hash + '-time');
            }

            // Pause all other tracks
            const audioElements = document.querySelectorAll('audio');
            for (let otherAudio of audioElements) {
                if (otherAudio !== audioElement) {
                    otherAudio.pause();
                    // Also reset the play button text of other tracks, if necessary
                    let otherButton = otherAudio.parentElement.querySelector('button');
                    if (otherButton) {
                        otherButton.textContent = 'Play';
                    }
                }
            }

            // Add listener for 'canplaythrough' event
            audioElement.addEventListener('canplaythrough', function () {
                updateTimeInfo(hash);
                updateProgress(hash);
            }, false);

            // Check if there's currentAudio and it's not the current audioElement
            if (currentAudio && currentAudio !== audioElement) {
                currentAudio.pause();
                if (currentButton) {
                    currentButton.textContent = 'Play';
                }
            }

            // Check if audio is paused and play or pause accordingly
            if (audioElement.paused) {
                audioElement.play();
                playButton.textContent = 'Stop';
                // Clear any existing intervals
                if (window.timeUpdateInterval) clearInterval(window.timeUpdateInterval);
                // Set a new interval to update the time and save current time to localStorage
                window.timeUpdateInterval = setInterval(function () {
                    updateTimeInfo(hash);
                    updateProgress(hash);
                    localStorage.setItem(hash + '-time', audioElement.currentTime);
                    localStorage.setItem(hash + '-progress', (audioElement.currentTime / audioElement.duration) * 100);
                }, 1000);
            } else {
                audioElement.pause();
                playButton.textContent = 'Play';
                // Clear the interval when audio is paused
                if (window.timeUpdateInterval) clearInterval(window.timeUpdateInterval);
            }

            // Update the currentAudio and currentButton
            currentAudio = audioElement;
            currentButton = playButton;
        }

        function updateTimeInfo(hash) {
            console.log("updateTimeInfo", hash);
            let audioElement = document.getElementById('audio-' + hash);
            let timeInfo = document.querySelector('#item-' + hash + ' .time-info');
            if (audioElement && timeInfo) {
                let duration = formatTime(Math.floor(audioElement.duration));
                let currentTime = formatTime(Math.floor(audioElement.currentTime));
                timeInfo.textContent = currentTime + ' / ' + duration;
            }

            if (audioElement && timeInfo) {
                localStorage[hash + '-progress'] = (Math.floor(audioElement.currentTime) / Math.floor(audioElement.duration)) * 100;
                localStorage[hash + '-time'] = Math.floor(audioElement.currentTime);
            }
        }

        function updateProgress(hash) {
            console.log("updateProgress", hash);
            let audioElement = document.getElementById('audio-' + hash);
            let progress = document.querySelector('#item-' + hash + ' .progress-bar-inner');
            if (audioElement && progress) {
                let percentage = (Math.floor(audioElement.currentTime) / Math.floor(audioElement.duration)) * 100;
                progress.style.width = percentage + '%';
            }
        }

        function seekAudio(event, hash) {
            let audioElement = document.querySelector('#item-' + hash + ' audio');
            let progressContainer = document.querySelector('#item-' + hash + ' .progress-bar');

            if (!audioElement || audioElement.readyState < 4) return;

            const rect = progressContainer.getBoundingClientRect();
            const percent = (event.clientX - rect.left) / rect.width;
            audioElement.currentTime = percent * audioElement.duration;

            // Manually call updateTimeInfo and updateProgress
            updateTimeInfo(hash);
            updateProgress(hash);
        }

        function restoreProgressAndTime() {
            let items = document.getElementsByClassName('mp3-item');
            for (let i = 0; i < items.length; i++) {
                let item = items[i];
                let hash = item.id.replace('item-', '');
                if (localStorage.getItem(hash + '-time')) {
                    let progressElement = document.querySelector('#item-' + hash + ' .progress-bar-inner');
                    let timeElement = document.querySelector('#item-' + hash + ' .time-info');
                    let formattedDuration = item.dataset.duration;
                    let percentage = localStorage.getItem(hash + '-progress');
                    let currentTime = localStorage.getItem(hash + '-time');
                    progressElement.style.width = percentage + '%';
                    let formattedCurrentTime = formatTime(currentTime);
                    timeElement.textContent = formattedCurrentTime + ' / ' + formattedDuration;
                }
            }
        }

        /* The global volume variable */
        let globalVolume = 1;

        window.openModal = function (event) {
            const modal = document.getElementById('settingsModal');
            const modalIcon = document.getElementById('settings-icon');

            modal.style.display = 'flex';
            modalIcon.style.display = 'none';
        }

        /* Listener for the settings modal close button */
        window.onclick = function (event) {
            const modal = document.getElementById('settingsModal');
            const modalIcon = document.getElementById('settings-icon');
            if (event.target === modal) {
                modal.style.display = 'none';
                modalIcon.style.display = 'block';
            }
        }

        /* Listener for the volume control slider */
        document.getElementById('volumeControl').addEventListener('input', function (event) {
            globalVolume = event.target.value / 100; // Convert from [0,100] to [0,1]
            // Apply new volume to all audio elements
            const audioElements = document.querySelectorAll('audio');
            for (let i = 0; i < audioElements.length; i++) {
                audioElements[i].volume = globalVolume;
            }
            // Save the volume setting to localStorage
            localStorage.setItem('globalVolume', globalVolume);
        });

        function restoreVolumeSetting() {
            // Check if a saved volume setting exists in localStorage
            if (localStorage.getItem('globalVolume')) {
                globalVolume = parseFloat(localStorage.getItem('globalVolume'));
                // Update the volume slider UI
                document.getElementById('volumeControl').value = globalVolume * 100;
                // Apply the volume setting to all audio elements
                const audioElements = document.querySelectorAll('audio');
                for (let audio of audioElements) {
                    audio.volume = globalVolume;
                }
            }
        }

        function restoreListenedToFiles() {
            let items = document.getElementsByClassName('mp3-item');
            for (let i = 0; i < items.length; i++) {
                let item = items[i];
                let hash = item.id.replace('item-', '');
                if (localStorage.getItem(hash + '-listened')) {
                    markAsListened(hash);
                }
            }
        }

        function markAsListened(hash) {
            let itemElement = document.getElementById('item-' + hash);
            itemElement.classList.add('listened');
            document.querySelector('#item-' + hash + ' .mark-listened').style.display = 'none';
            document.querySelector('#item-' + hash + ' .mark-not-listened').style.display = 'block';

            // Store in localStorage
            localStorage.setItem(hash + '-listened', true);
        }

        function markAsNotListened(hash) {
            let itemElement = document.getElementById('item-' + hash);
            itemElement.classList.remove('listened');
            document.querySelector('#item-' + hash + ' .mark-listened').style.display = 'block';
            document.querySelector('#item-' + hash + ' .mark-not-listened').style.display = 'none';

            // Remove from localStorage
            localStorage.removeItem(hash + '-listened');
        }

        /* Dark Mode functionality */
        let darkMode = true;

        /* Listener for the settings modal close button */
        let modal = document.getElementById('settingsModal');
        let modalIcon = document.getElementById('settings-icon');
        let closeButton = modal.getElementsByClassName('close')[0];
        closeButton.onclick = function () {
            modal.style.display = 'none';
            modalIcon.style.display = 'block';
        }

        /* Dark Mode functionality */
        function toggleDarkMode() {
            const body = document.body;
            body.classList.toggle('light-mode');
        }

        // Call the function when page loads
        window.onload = function () {
            restoreProgressAndTime();
            restoreVolumeSetting();
            restoreListenedToFiles();
        };
    </script>
    </body>
    </html>

<?php

/**
 * This class represents and is able to read and manipulate a MPEG audio
 * @author         Soroush Falahati https://falahati.net
 * @copyright      Soroush Falahati (C) 2017
 * @license        LGPL v3 https://www.gnu.org/licenses/lgpl-3.0.en.html
 * @link           https://github.com/falahati/PHP-MP3
 * @formatter:off
 */
class MpegAudio{private $memory="";private $memoryPointer=0;private $memoryLength=0;private $resource=null;private $frames=-1;private $duration=0.0;private $frameOffsetTable=[];private $frameTimingTable=[];public static function fromFile($path){$inMemory=true;if($inMemory){return self::fromData(file_get_contents($path));}else{}}public static function fromData($data){if(!is_string($data)){return false;}$audio=new MpegAudio();$audio->memory=$data;$audio->memoryLength=strlen($audio->memory);return $audio;}private function read($length=0,$index=-1){if($this->resource===null){if($index<0){$index=$this->memoryPointer;}if($length==0){$length=$this->memoryLength-$index;}$this->memoryPointer=min($this->memoryLength,$index+$length);if($this->memoryPointer>=$this->memoryLength){return false;}return substr($this->memory,$index,$length);}else{}}private function write($data,$index=-1){if($this->resource===null){$length=strlen($data);$this->slice($length,$index);return $this->insert($data,$index);}else{}}private function insert($data,$index=-1){if($this->resource===null){if($index<0){$index=$this->memoryPointer;}$length=strlen($data);$this->memoryPointer=$index+$length;$this->memory=substr($this->memory,0,$index).$data.substr($this->memory,$index);$this->memoryLength+=strlen($data);return $length;}else{}}private function slice($length=0,$index=-1){if($this->resource===null){if($index<0){$index=$this->memoryPointer;}if($length==0){$length=$this->memoryLength-$index;}$this->memoryPointer=$index;$length=max(min($this->memoryLength-$index,$length),0);$this->memory=substr($this->memory,0,$index).substr($this->memory,$index+$length);$this->memoryLength-=$length;return $length;}else{}}private function seek($index=-1){if($index<0){if($this->resource===null){return $this->memoryPointer;}else{}}if($this->resource===null){$this->memoryPointer=$index;return true;}else{}}public function __construct(){$this->reset();$this->memory="";}private function reset(){$this->frames=-1;$this->frameTimingTable=[];$this->frameOffsetTable=[];$this->duration=0.0;}private function analyze(){$offset=$this->getStart();$this->frames=0;$this->frameOffsetTable=[];$this->frameTimingTable=[];$this->duration=0.0;if($offset!==false){while(true){$frameHeader=$this->readFrameHeader($offset);if($frameHeader===false){$offset=$this->getStart($offset);if($offset!==false){continue;}break;}$this->duration+=$frameHeader->getDuration();$this->frameOffsetTable[$this->frames]=$frameHeader->getOffset();$this->frameTimingTable[$this->frames]=$this->duration;$this->frames++;$offset=$frameHeader->getOffset()+$frameHeader->getLength();unset($frameHeader);}}}private function getStart($offset=0){$offset--;while(true){$offset++;$byte=$this->read(1,$offset);if($byte===false){return false;}if($byte!=chr(255)){continue;}$frameHeader=$this->readFrameHeader($offset);if($frameHeader===false){continue;}$frameHeader=$this->readFrameHeader($frameHeader->getOffset()+$frameHeader->getLength());if($frameHeader===false){continue;}return $offset;}}private function readFrameHeader($offset){$bytes=$this->read(4,$offset);return MpegAudioFrameHeader::tryParse($bytes,$offset);}public function saveFile($path){if($this->resource===null){file_put_contents($path,$this->memory);}else{fflush($this->resource);}return $this;}public function close(){if($this->resource===null){$data=$this->memory;$this->memory="";$this->memoryLength=0;$this->memoryPointer=0;return $data;}if($this->resource!==null&&fclose($this->resource)){$this->resource=null;return true;}return false;}public function getFrameCounts(){if($this->frames<0){$this->analyze();}return $this->frames;}public function getTotalDuration(){if($this->getFrameCounts()){return $this->duration;}return 0.0;}public function getFrameHeader($index){if($index>=0&&$index<$this->getFrameCounts()){return $this->readFrameHeader($this->frameOffsetTable[$index]);}return false;}public function getFrameData($index){$frameHeader=$this->getFrameHeader($index);if($frameHeader!==false){return $this->read($frameHeader->getOffset(),$frameHeader->getLength());}return false;}public function removeFrame($index,$count=1){if($count<0){$index+=$count;$count*=-1;}if($index<0||$index>=$this->getFrameCounts()){return $this;}$count=min($this->getFrameCounts()-$index,$count);if($count==0){return $this;}$firstFrameHeader=$this->getFrameHeader($index);$lastFrameHeader=$this->getFrameHeader($index+($count-1));$this->slice(($lastFrameHeader->getOffset()+$lastFrameHeader->getLength())-$firstFrameHeader->getOffset(),$firstFrameHeader->getOffset());$this->reset();return $this;}public function append(MpegAudio $srcAudio,$index=0,$length=-1){if($index<0||$index>=$srcAudio->getFrameCounts()){return $this;}if($length<0){$length=$srcAudio->getFrameCounts()-$index;}$length=min($srcAudio->getFrameCounts()-$index,$length);$srcFirstFrameHeader=$srcAudio->getFrameHeader($index);$srcLastFrameHeader=$srcAudio->getFrameHeader($index+($length-1));$data=$srcAudio->read(($srcLastFrameHeader->getOffset()+$srcLastFrameHeader->getLength())-$srcFirstFrameHeader->getOffset(),$srcFirstFrameHeader->getOffset());if($data){$endOfStream=0;if($this->getFrameCounts()>0){$frameHeader=$this->getFrameHeader($this->getFrameCounts()-1);if($frameHeader!==false){$endOfStream=$frameHeader->getOffset()+$frameHeader->getLength();}}$this->insert($data,$endOfStream);$this->analyze();}return $this;}public function trim($startTime,$duration=0){if($startTime<0){$startTime=$this->getTotalDuration()+$startTime;}if($duration<=0){$duration=$this->getTotalDuration()-$startTime;}$endTime=min($startTime+$duration,$this->getTotalDuration());$startIndex=0;$endIndex=0;foreach($this->frameTimingTable as $frameIndex=>$frameTiming){if($frameTiming<=$startTime){$startIndex=$frameIndex;}else{if($frameTiming>=$endTime){$endIndex=$frameIndex;break;}}}$this->removeFrame($endIndex,$this->getFrameCounts()-$endIndex);$this->removeFrame(0,$startIndex);return $this;}public function getBeginingTags(){$start=$this->getStart();if($start===false){return false;}return $this->read($start,0);}public function getEndingTags(){$frames=$this->getFrameCounts();if($frames===0){return false;}$frame=$this->getFrameHeader($frames-1);if($frame===false){return false;}return $this->read(0,$frame->getOffset()+$frame->getLength());}public function stripTags(){$frames=$this->getFrameCounts();if($frames>0){$frame=$this->getFrameHeader($frames-1);if($frame!==false){$this->slice(0,$frame->getOffset()+$frame->getLength());}}$start=$this->getStart();if($start!==false&&$start>0){$this->slice($start,0);}$this->reset();return $this;}}
//@formatter:on

/**
 * This class represents a MPEG audio frame's header
 * @author         Soroush Falahati https://falahati.net
 * @copyright      Soroush Falahati (C) 2017
 * @license        LGPL v3 https://www.gnu.org/licenses/lgpl-3.0.en.html
 * @link           https://github.com/falahati/PHP-MP3
 * @formatter:off
 */
class MpegAudioFrameHeader{const Version_10=1;const Version_20=2;const Version_25=3;const Profile_1=1;const Profile_2=2;const Profile_3=3;const Mode_Stereo=0;const Mode_JointStereo=1;const Mode_DualChannel=2;const Mode_SingleChannel=3;const IntensityStereo_Disable=0;const IntensityStereo_Auto=1;const IntensityStereo_Bands4_31=2;const IntensityStereo_Bands8_31=3;const IntensityStereo_Bands12_31=4;const IntensityStereo_Bands16_31=5;private $bitRate=0;private $sampleRate=0;private $version=-1;private $profile=-1;private $duration=0.0;private $offset=0;private $length=0;private $padding=0;private $errorProtection=false;private $privateBit=false;private $copyrighted=false;private $original=false;private $mode=self::Mode_Stereo;private $middleSideStereoJoining=false;private $intensityStereoMode=self::IntensityStereo_Disable;private static $binaryTable=[];private static $bitRateTable=[];private static $sampleRateTable=[];public function getBitRate(){return $this->bitRate;}public function getSampleRate(){return $this->sampleRate;}public function getVersion(){return $this->version;}public function getLayerProfile(){return $this->profile;}public function getDuration(){return $this->duration;}public function getOffset(){return $this->offset;}public function getLength(){return $this->length;}public function getPadding(){return $this->padding;}public function isErrorProtectionEnable(){return $this->errorProtection;}public function isPrivateBitActive(){return $this->privateBit;}public function isCopyrighted(){return $this->copyrighted;}public function isOriginal(){return $this->original;}public function getChannelMode(){return $this->mode;}public function isMiddleSideStereoJoiningEnable(){return $this->middleSideStereoJoining;}public function getIntensityStereoMode(){return $this->intensityStereoMode;}private function __construct(){if(!self::$binaryTable){for($i=0;$i<256;$i++){self::$binaryTable[chr($i)]=sprintf('%08b',$i);}}if(!self::$bitRateTable){self::$bitRateTable=['0000'=>[0,0,0,0,0],'0001'=>[32,32,32,32,8],'0010'=>[64,48,40,48,16],'0011'=>[96,56,48,56,24],'0100'=>[128,64,56,64,32],'0101'=>[160,80,64,80,40],'0110'=>[192,96,80,96,48],'0111'=>[224,112,96,112,56],'1000'=>[256,128,112,128,64],'1001'=>[288,160,128,144,80],'1010'=>[320,192,160,160,96],'1011'=>[352,224,192,176,112],'1100'=>[384,256,224,192,128],'1101'=>[416,320,256,224,144],'1110'=>[448,384,320,256,160],'1111'=>[-1,-1,-1,-1,-1],];}if(!self::$sampleRateTable){self::$sampleRateTable=[self::Version_10=>['00'=>44100,'01'=>48000,'10'=>32000,'11'=>0,],self::Version_20=>['00'=>22050,'01'=>24000,'10'=>16000,'11'=>0,],self::Version_25=>['00'=>11025,'01'=>12000,'10'=>8000,'11'=>0,],];}}public static function tryParse($headerBytes,$offset){$frame=new self();$frame->offset=$offset;$headerBits=[];for($i=0;$i<strlen($headerBytes);$i++){$headerBits[]=self::$binaryTable[$headerBytes[$i]];}if(count($headerBits)<4||$headerBits[0]!=='11111111'||substr($headerBits[1],0,3)!=='111'){return false;}switch(substr($headerBits[1],3,2)){case '01':return false;case '00':$frame->version=self::Version_25;break;case '10':$frame->version=self::Version_20;break;case '11':$frame->version=self::Version_10;break;}switch(substr($headerBits[1],5,2)){case '01':$frame->profile=self::Profile_3;break;case '00':return false;case '10':$frame->profile=self::Profile_2;break;case '11':$frame->profile=self::Profile_1;break;}$frame->errorProtection=!!(substr($headerBits[1],7,1));$frame->bitRate=-1;$bitRateIndex=substr($headerBits[2],0,4);if($frame->version==self::Version_10){switch($frame->profile){case self::Profile_1:$frame->bitRate=self::$bitRateTable[$bitRateIndex][0];break;case self::Profile_2:$frame->bitRate=self::$bitRateTable[$bitRateIndex][1];break;case self::Profile_3:$frame->bitRate=self::$bitRateTable[$bitRateIndex][2];break;}}else{switch($frame->profile){case self::Profile_1:$frame->bitRate=self::$bitRateTable[$bitRateIndex][3];break;case self::Profile_2:case self::Profile_3:$frame->bitRate=self::$bitRateTable[$bitRateIndex][4];break;}}if($frame->bitRate<=0){return false;}$frame->bitRate*=1000;$frame->sampleRate=self::$sampleRateTable[$frame->version][substr($headerBits[2],4,2)];if($frame->sampleRate<=0){return false;}$frame->padding=substr($headerBits[2],6,1)?1:0;$frame->privateBit=!!(substr($headerBits[2],7,1));switch(substr($headerBits[3],0,2)){case '00':$frame->mode=self::Mode_Stereo;break;case '01':$frame->mode=self::Mode_JointStereo;break;case '10':$frame->mode=self::Mode_DualChannel;break;case '11':$frame->mode=self::Mode_SingleChannel;break;}if($frame->profile==self::Profile_1||$frame->profile==self::Profile_2){$frame->middleSideStereoJoining=false;switch(substr($headerBits[3],2,2)){case '00':$frame->intensityStereoMode=self::IntensityStereo_Bands4_31;break;case '01':$frame->intensityStereoMode=self::IntensityStereo_Bands8_31;break;case '10':$frame->intensityStereoMode=self::IntensityStereo_Bands12_31;break;case '11':$frame->intensityStereoMode=self::IntensityStereo_Bands16_31;break;}}else{if($frame->profile==self::Profile_3){$frame->intensityStereoMode=substr($headerBits[3],2,1)?self::IntensityStereo_Auto:self::IntensityStereo_Disable;$frame->middleSideStereoJoining=!!(substr($headerBits[3],3,1));}}$frame->copyrighted=!!(substr($headerBits[3],4,4));$frame->original=!!(substr($headerBits[3],5,1));if($frame->profile==self::Profile_1){$frame->length=(((12*$frame->bitRate)/$frame->sampleRate)+$frame->padding)*4;}else{if($frame->profile==self::Profile_2||$frame->profile==self::Profile_3){$frame->length=((144*$frame->bitRate)/$frame->sampleRate)+$frame->padding;}}$frame->length=floor($frame->length);if($frame->length<=0){return false;}$frame->duration=$frame->length*8/$frame->bitRate;return $frame;}}
//@formatter:on