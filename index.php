<?php

$settings = [
    'lang'      => 'en',
    'languages' => ['en' => 'English', 'sk' => "Slovenčina"],
    'title'     => 'BookPlayer',
    'subtitle'  => 'by <a href="https://v2.sk/" target="_blank" title="Version Two - versiontwo.sk - Websites, mobile apps, custom systems ...">v2.sk</a>',
];

//*  DO NOT EDIT BEYOND THIS POINT  *//

if (!is_dir('.metadata')) {
    mkdir('.metadata');

    initMetaDataFolder();
    initPageJson();
}
if (!is_dir('.metadata/lang')) {
    mkdir('.metadata/lang');
}

if (file_exists('.metadata/page.json')) {
    $settings = array_merge($settings, json_decode(file_get_contents('.metadata/page.json'), true));
}
if (!file_exists('.metadata/lang/en.json')) {
    file_put_contents('.metadata/lang/en.json', json_encode(["settings_title" => "Settings", "language_title" => "Language:", "speed_title" => "Speed:", "volume_control_label" => "Volume control:", "speed_label" => "Speed: ", "reset_button" => "Reset", "play" => "Play", "stop" => "Stop", "pause" => "Pause", "play_resume_button_text_beginning" => "Play from beginning", "resume_playback_button_text" => "Resume playback", "mark_as_listened_tooltip" => "Mark as listened to", "mark_as_not_listened_tooltip" => "Mark as not listened to", "play_audio_error" => "Required elements not found for:", "no_mp3_items_error" => "No MP3 items found on the page", "playback_error" => "Error attempting to play audio:",]), true);
}
if (!file_exists('.metadata/lang/sk.json')) {
    file_put_contents('.metadata/lang/sk.json', json_encode(["settings_title" => "Nastavenia", "language_title" => "Jazyk:", "speed_title" => "Rýchlosť:", "volume_control_label" => "Ovládanie hlasitosti:", "speed_label" => "Rýchlosť prehrávania: ", "reset_button" => "Reset", "play" => "Prehrať", "stop" => "Zastaviť", "pause" => "Pauza", "play_resume_button_text_beginning" => "Prehrať od začiatku", "resume_playback_button_text" => "Pokračovať v prehrávaní", "mark_as_listened_tooltip" => "Označiť ako vypočuté", "mark_as_not_listened_tooltip" => "Označiť ako nevypočuté", "play_audio_error" => "Požadované prvky neboli nájdené pre:", "no_mp3_items_error" => "Na stránke neboli nájdené žiadne MP3 položky", "playback_error" => "Chyba pri pokuse o prehranie zvuku:"]), true);
}
$language = $_COOKIE['lang'] ?? $settings['lang'];

if (!array_key_exists($language, $settings['languages'])) {
    $language = 'en';
}

$translationLines = json_decode(file_get_contents('.metadata/lang/' . $language . '.json'), true);

$files = glob("*.mp3");
natsort($files);
$fileCount = count($files);
?>
    <!DOCTYPE html>
    <html lang="<?= $language ?>">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
        <title><?= $settings['title'] ?></title>
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
                max-height       : 100vh;
                overflow         : hidden;
            }

            .main-container {
                display        : flex;
                flex-direction : column;
                align-items    : center;
                height         : 100%;
                overflow       : auto;
                padding        : 20px;
            }

            .center-content {
                justify-content : center;
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
                min-width        : 600px;
                box-sizing       : border-box;
            }

            .mp3-item:hover {
                background-color : #2a2a2a;
            }

            .mp3-title {
                margin-bottom : 5px;
                max-width     : 90%;
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
                transition       : all 200ms ease-in;
                height           : 10px;
                background-color : #007bff;
                width            : 0;
            }

            #playResumeButton {
                margin-bottom : 30px;
            }

            @media (max-width : 600px) {
                .main-container {
                    display : block;
                }

                .mp3-container {
                    border-radius : 0;
                }

                .mp3-item {
                    min-width : 200px;
                    max-width : 100vw;
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

                .settings-icon {
                    width  : 25px !important;
                    height : 25px !important;
                    top    : 28px !important
                }

                #playResumeButton {
                    position        : fixed;
                    bottom          : 20px;
                    right           : 20px;
                    width           : 50px;
                    height          : 50px;
                    border-radius   : 50%;
                    font-size       : 20px;
                    display         : flex;
                    align-items     : center;
                    justify-content : center;
                    padding         : 0;
                    z-index         : 10;
                    margin-bottom   : 0;
                    box-shadow      : 0 3px 6px rgba(0, 0, 0, 0.16);
                }

                #playResumeButton span {
                    display : block;
                }

                #playResumeButton .fa {
                    margin : 0;
                }

                #playResumeButton #playResumeText {
                    display : none;
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
                right    : 30px;
                width    : 50px;
                height   : 50px;
                cursor   : pointer;
                fill     : #ffffff;
                stroke   : #ffffff;
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
                z-index          : 1;
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

            .speed-control-container {
                display         : flex;
                align-items     : center;
                justify-content : space-between;
                margin-bottom   : 10px;
            }

            .speed-control-container label {
                margin-right : 10px;
            }

            .slider-and-button {
                display         : flex;
                align-items     : center;
                justify-content : space-between;
                width           : 100%;
            }

            #speedSlider {
                flex-grow    : 1;
                margin-right : 5%;
            }

            #resetSpeedButton {
                width     : 25%;
                padding   : 5px;
                font-size : 0.8em;
            }

            .language-selection {
                margin-top : 10px;
            }

            .language-selection label {
                margin-right : 5px;
            }

            #languageSelect {
                padding   : 5px;
                font-size : 1em;
            }
        </style>
    </head>
    <body>
    <div class="settings-modal" id="settingsModal" style="display: none;">
        <div class="settings-modal-content">
            <span class="close">&times;</span>

            <h2><?= $translationLines['settings_title']; ?></h2>
            <label for="volumeControl"><?= $translationLines['volume_control_label']; ?></label>
            <input type="range" min="0" max="100" value="100" class="slider" id="volumeControl">
            <br>
            <label for="speedSlider"><?= $translationLines['speed_title']; ?> </label>
            <div class="speed-control-container">
                <div class="slider-and-button">
                    <input type="range" id="speedSlider" min="0.25" max="2" step="0.05" value="1" style="width: 70%;">
                    <button id="resetSpeedButton" style="width: 25%;"><?= $translationLines['reset_button']; ?></button>
                </div>
            </div>
            <br>
            <div class="language-selection">
                <label for="languageSelect"><?= $translationLines['language_title']; ?></label>
                <select id="languageSelect" onchange="audioPlayer.changeLanguage(this.value)">
                    <?php
                    foreach ($settings['languages'] as $newLang => $newLangTitle) {
                        echo '<option value="' . $newLang . '" ' . ($newLang == $language ? 'selected' : '') . '>' . $newLangTitle . '</option>';
                    }
                    ?>
                </select>
            </div>
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


    <div class="main-container <?= $fileCount > 4 ? '' : 'center-content' ?>">
        <?php if (isset($settings['title'])): ?>
            <h1 class="page-title"><?= $settings['title'] ?></h1>
        <?php endif; ?>

        <?php if (isset($settings['subtitle'])): ?>
            <p class="page-subtitle"><?= $settings['subtitle'] ?></p>
        <?php endif; ?>
        <div style="text-align: center">
            <button id="playResumeButton" onclick="audioPlayer.playOrResume()">
                <span id="playResumeIcon" class="fa fa-play"></span>
                <span id="playResumeText"><?= $translationLines['play']; ?></span>
            </button>

        </div>
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

            function initPageJson()
            {
                file_put_contents('.metadata' . DIRECTORY_SEPARATOR . 'page.json', '{"lang": "en","title": "BookPlayer","subtitle": "by <a href=\"https://v2.sk/\" target="_blank" title="Version Two - versiontwo.sk - Websites, mobile apps, custom systems ...">v2.sk</a>"}');
            }

            function initMetaDataFolder()
            {
                file_put_contents('.metadata' . DIRECTORY_SEPARATOR . '.htaccess', 'Options -MultiViews -Indexes');
            }

            function getMP3Details($filename)
            {
                $hash         = getMD5Hash($filename);
                $jsonFilename = '.metadata/' . pathinfo($filename, PATHINFO_FILENAME) . '.json';
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
                echo '<button title="' . $translationLines['mark_as_listened_tooltip'] . '" class="mark-listened" onclick="audioPlayer.markAsListened(\'' . $hash . '\')"><i class="fa-solid fa-file-audio"></i></button>
                      <button title="' . $translationLines['mark_as_not_listened_tooltip'] . '" class="mark-not-listened" onclick="audioPlayer.markAsNotListened(\'' . $hash . '\')" style="display:none;"><i class="fa-regular fa-file-audio"></i></button>';
                echo '<div class="mp3-title" onclick="audioPlayer.toggleDescription(\'' . $hash . '\')" >' . $title;
                if (!is_null($description)) {
                    echo '&nbsp;<span class="expand-caret caret-' . $hash . '">&#9660;</span>';
                }
                echo '</div>';
                echo '<div class="mp3-controls">';
                echo '<button id="play-' . $hash . '" class="play-button" onclick="audioPlayer.playAudio(\'' . $hash . '\')">' . $translationLines['play'] . '</button>';
                echo '<div class="progress-bar" onclick="audioPlayer.seekAudio(event, \'' . $hash . '\')"><div class="progress-bar-inner"></div></div>';
                echo '<div class="time-info">00:00 / ' . $formattedDuration . '</div>'; // Use the formatted duration here
                echo '</div>';
                if (!is_null($description)) {
                    echo '<div class="mp3-description" onclick="audioPlayer.toggleDescription(\'' . $hash . '\')" id="desc-' . $hash . '">' . htmlspecialchars($description) . '</div>';
                }
                echo '<audio preload="metadata" onloadedmetadata="audioPlayer.updateTimeInfo(\'' . $hash . '\')" ontimeupdate="audioPlayer.updateProgress(\'' . $hash . '\')" id="audio-' . $hash . '" data-hash="' . $hash . '"></audio>';
                echo '</div>';
            }

            ?>
        </div>
    </div>

    <script>
        class AudioPlayer {
            constructor() {
                this.currentSpeed = 1;
                this.currentAudio = null;
                this.currentButton = null;
                this.currentlyPlaying = false;
                this.currentHash = '';
                this.globalVolume = 1;
                this.darkMode = true;
                this.timeUpdateInterval = null;

                this.initializeEventListeners();
                this.restoreSettings();
                this.updatePlayResumeButton();
                this.updatePlayResumeButtonIcon();
            }

            initializeEventListeners() {
                window.onload = () => this.restoreSettings();
                window.onresize = () => this.updatePlayResumeButtonIcon();
                document.getElementById('volumeControl').addEventListener('input', this.handleVolumeChange.bind(this));
                document.getElementById('speedSlider').addEventListener('input', this.handleSpeedChange.bind(this));
                document.getElementById('resetSpeedButton').addEventListener('click', this.resetSpeed.bind(this));
                document.getElementById('settingsModal').onclick = this.handleModalClick.bind(this);
                document.getElementById('settings-icon').onclick = () => this.openModal();
                document.getElementById('playResumeButton').onclick = () => this.playOrResume();
            }

            restoreSettings() {
                this.restoreProgressAndTime();
                this.restoreVolumeSetting();
                this.restoreListenedToFiles();
                this.restoreSpeedSetting();
                this.updatePlayResumeButtonIcon();
            }

            playAudio(hash) {
                let shouldReProgress = true;
                this.currentlyPlaying = !this.currentlyPlaying;
                if (this.currentHash === hash) {
                    shouldReProgress = false;
                }
                this.currentHash = hash;

                let itemElement = document.getElementById('item-' + hash);
                let encodedFilename = itemElement.dataset.filename;
                let audioElement = document.getElementById('audio-' + hash);
                let playButton = document.getElementById('play-' + hash);

                if (!itemElement || !audioElement || !playButton) {
                    console.error('<?= $translationLines['play_audio_error'];?>', encodedFilename);
                    return;
                }

                if (!audioElement.src) {
                    audioElement.src = decodeURIComponent(encodedFilename);
                }

                if (shouldReProgress) {
                    localStorage.setItem('lastPlayed', hash);
                    this.setProgressFromLocalStorage(hash, audioElement);
                    this.pauseAllOtherAudios(audioElement);
                }

                if (audioElement.paused) {
                    let startFromBeginning = false;
                    if (audioElement.dataset.progress !== null && audioElement.dataset.progress == 100) {
                        startFromBeginning = true;
                    }

                    const playPromise = audioElement.play();
                    audioElement.playbackRate = this.currentSpeed;
                    if (startFromBeginning) {
                        audioElement.currentTime = 0;
                    }

                    if (playPromise !== undefined) {
                        playPromise.then(() => {
                            // Playback started successfully
                            playButton.textContent = '<?= $translationLines['stop'];?>';
                            // Set a new interval to update the time
                            this.timeUpdateInterval = setInterval(() => {
                                let progress = (audioElement.currentTime / audioElement.duration) * 100;

                                this.updateTimeInfo(hash);
                                this.updateProgress(hash);

                                if (progress === 100) {
                                    clearInterval(this.timeUpdateInterval);
                                    this.stopAudio(hash);
                                    this.playNextTrack(hash);
                                }
                            }, 1000);
                        }).catch(error => {
                            console.error('<?= $translationLines['playback_error'];?>', error);
                        });
                    }
                } else {
                    this.stopAudio(hash);
                    if (this.timeUpdateInterval) clearInterval(this.timeUpdateInterval);
                }

                this.updatePlayResumeButton(hash);
                this.updatePlayResumeButtonIcon();
            }

            stopAudio(hash) {
                this.currentlyPlaying = false;
                clearInterval(this.timeUpdateInterval);
                const audioElement = document.getElementById('audio-' + hash);
                const playButton = document.getElementById('play-' + hash);

                if (audioElement) {
                    audioElement.pause();
                    playButton.textContent = '<?= $translationLines['play'];?>';
                }
            }

            playNextTrack(currentHash) {
                this.markAsListened(currentHash);
                let nextItemElement = document.getElementById('item-' + currentHash).nextElementSibling;

                if (nextItemElement && nextItemElement.classList.contains('mp3-item')) {
                    let nextHash = nextItemElement.id.replace('item-', '');
                    this.playAudio(nextHash);
                }
            }

            playOrResume() {
                let lastPlayedHash = localStorage.getItem('lastPlayed');
                if (this.currentlyPlaying) {
                    lastPlayedHash = this.currentHash;
                }

                if (lastPlayedHash) {
                    const lastAudioElement = document.getElementById('audio-' + lastPlayedHash);
                    if (lastAudioElement) {
                        if (lastAudioElement.paused) {
                            this.playAudio(lastPlayedHash);
                        } else {
                            this.stopAudio(lastPlayedHash);
                        }
                    } else {
                        this.playFirstTrack();
                    }
                } else {
                    this.playFirstTrack();
                }
                this.updatePlayResumeButtonIcon(lastPlayedHash);
            }

            updatePlayResumeButton(hash = null) {
                let lastPlayedHash = hash;
                if (lastPlayedHash === null) {
                    lastPlayedHash = localStorage.getItem('lastPlayed');
                }
                const button = document.getElementById('playResumeButton');
                const buttonTextSpan = document.getElementById('playResumeText');
                let buttonText = '<?= $translationLines['play_resume_button_text_beginning']; ?>';
                console.log('1');
                if (lastPlayedHash) {
                    const lastAudioElement = document.getElementById('audio-' + lastPlayedHash);
                    if (lastAudioElement) {
                        console.log('2');
                        if (!lastAudioElement.paused && !lastAudioElement.ended) {
                            // If currently playing
                            buttonText = '<?= $translationLines['pause']; ?>';
                            console.log('3');
                        } else if (lastAudioElement.paused && lastAudioElement.currentTime > 0 && !lastAudioElement.ended) {
                            // If paused, has progress, and not ended
                            buttonText = '<?= $translationLines['resume_playback_button_text']; ?>';
                            console.log('4');
                        } else {
                            buttonText = '<?= $translationLines['resume_playback_button_text']; ?>';
                            console.log('5');
                        }
                    } else {
                        // If lastPlayedHash exists but corresponding audio element not found
                        buttonText = '<?= $translationLines['play_resume_button_text_beginning']; ?>';
                        console.log('6');
                    }
                }

                // Update the text content of the playResumeText span
                buttonTextSpan.textContent = buttonText;

                // Disable the button if there are no MP3 files
                button.disabled = document.querySelectorAll('.mp3-item').length === 0;

                // Update the icon of the play/resume button
                this.updatePlayResumeButtonIcon();
            }

            updatePlayResumeButtonIcon(hash = null) {
                let lastPlayedHash = hash;
                if (lastPlayedHash === null) {
                    lastPlayedHash = localStorage.getItem('lastPlayed');
                }
                const playResumeIcon = document.getElementById('playResumeIcon');
                const audioElement = lastPlayedHash ? document.getElementById('audio-' + lastPlayedHash) : null;

                if (audioElement && !audioElement.paused && !audioElement.ended) {
                    // Change to pause icon if the audio is playing
                    playResumeIcon.classList.remove('fa-play');
                    playResumeIcon.classList.add('fa-stop');
                } else {
                    // Change to play icon if the audio is not playing
                    playResumeIcon.classList.remove('fa-stop');
                    playResumeIcon.classList.add('fa-play');
                }

                if (audioElement && audioElement.ended) {
                    playResumeIcon.classList.remove('fa-stop');
                    playResumeIcon.classList.add('fa-play');
                }
            }

            handleVolumeChange(event) {
                this.globalVolume = event.target.value / 100;
                const audioElements = document.querySelectorAll('audio');
                audioElements.forEach(audio => {
                    audio.volume = this.globalVolume;
                });
                localStorage.setItem('globalVolume', this.globalVolume);
            }

            handleSpeedChange(event) {
                const speed = parseFloat(event.target.value);
                this.updateAudioSpeed(speed);
                localStorage.setItem('globalPlaybackSpeed', speed);
            }

            resetSpeed() {
                this.updateAudioSpeed(1);
                document.getElementById('speedSlider').value = 1;
                localStorage.setItem('globalPlaybackSpeed', '1');
            }

            updateAudioSpeed(speed) {
                const audioElements = document.querySelectorAll('audio');
                audioElements.forEach(audio => {
                    audio.playbackRate = speed;
                });
                this.currentSpeed = speed;
            }

            restoreVolumeSetting() {
                const savedVolume = parseFloat(localStorage.getItem('globalVolume')) || 1;
                this.globalVolume = savedVolume;
                document.getElementById('volumeControl').value = savedVolume * 100;
                this.handleVolumeChange({target: {value: savedVolume * 100}});
            }

            restoreListenedToFiles() {
                const items = document.getElementsByClassName('mp3-item');
                Array.from(items).forEach(item => {
                    const hash = item.id.replace('item-', '');
                    if (localStorage.getItem(hash + '-listened')) {
                        this.markAsListened(hash);
                    }
                });
            }

            restoreSpeedSetting() {
                const savedSpeed = parseFloat(localStorage.getItem('globalPlaybackSpeed')) || 1;
                this.updateAudioSpeed(savedSpeed);
                document.getElementById('speedSlider').value = savedSpeed;
            }

            restoreProgressAndTime() {
                let items = document.getElementsByClassName('mp3-item');
                for (let i = 0; i < items.length; i++) {
                    let item = items[i];
                    let hash = item.id.replace('item-', '');
                    if (localStorage.getItem(hash + '-time')) {
                        let audioElement = document.querySelector('#item-' + hash + ' .progress-bar-inner');
                        let progressElement = document.querySelector('#item-' + hash + ' .progress-bar-inner');
                        let timeElement = document.querySelector('#item-' + hash + ' .time-info');
                        let formattedDuration = item.dataset.duration;
                        let percentage = localStorage.getItem(hash + '-progress');
                        let currentTime = localStorage.getItem(hash + '-time');
                        progressElement.style.width = percentage + '%';
                        let formattedCurrentTime = this.formatTime(currentTime);
                        timeElement.textContent = formattedCurrentTime + ' / ' + formattedDuration;

                        audioElement.dataset.progress = percentage;
                    }
                }
            }

            openModal() {
                document.getElementById('settingsModal').style.display = 'flex';
                document.getElementById('settings-icon').style.display = 'none';
            }

            handleModalClick(event) {
                const modal = document.getElementById('settingsModal');
                if (event.target === modal) {
                    modal.style.display = 'none';
                    document.getElementById('settings-icon').style.display = 'block';
                }
            }

            setProgressFromLocalStorage(hash, audioElement) {
                const progressElement = document.querySelector('#item-' + hash + ' .progress-bar-inner');

                if (localStorage.getItem(hash + '-time')) {
                    const percentage = localStorage.getItem(hash + '-progress');
                    progressElement.style.width = percentage + '%';
                    audioElement.currentTime = localStorage.getItem(hash + '-time');
                }
            }

            pauseAllOtherAudios(currentHash) {
                const audioElements = document.querySelectorAll('audio');
                audioElements.forEach(audio => {
                    if (audio.dataset.hash !== currentHash) {
                        let audioHash = audio.dataset.hash;
                        this.stopAudio(audioHash);
                        const playButton = audio.parentElement.querySelector('button.play-button');
                        if (playButton) playButton.textContent = '<?= $translationLines['play']; ?>';
                    }
                });
            }

            startProgressInterval(hash) {
                const audioElement = document.getElementById('audio-' + hash);
                this.timeUpdateInterval = setInterval(() => {
                    let progress = (audioElement.currentTime / audioElement.duration) * 100;

                    this.updateTimeInfo(hash);
                    this.updateProgress(hash);

                    localStorage.setItem(hash + '-time', audioElement.currentTime);
                    localStorage.setItem(hash + '-progress', (audioElement.currentTime / audioElement.duration) * 100);

                    if (progress === 100) {
                        clearInterval(this.timeUpdateInterval);
                        this.stopAudio(hash);
                        this.playNextTrack(hash);
                    }
                }, 1000);
            }

            markAsListened(hash) {
                let itemElement = document.getElementById('item-' + hash);
                if (itemElement && !itemElement.classList.contains('listened')) {
                    itemElement.classList.add('listened');
                    document.querySelector('#item-' + hash + ' .mark-listened').style.display = 'none';
                    document.querySelector('#item-' + hash + ' .mark-not-listened').style.display = 'block';
                    localStorage.setItem(hash + '-listened', true);
                }
            }

            markAsNotListened(hash) {
                let itemElement = document.getElementById('item-' + hash);
                if (itemElement && itemElement.classList.contains('listened')) {
                    itemElement.classList.remove('listened');
                    document.querySelector('#item-' + hash + ' .mark-listened').style.display = 'block';
                    document.querySelector('#item-' + hash + ' .mark-not-listened').style.display = 'none';
                    localStorage.removeItem(hash + '-listened');
                }
            }

            playFirstTrack() {
                const firstItemHash = document.querySelector('.mp3-item')?.id.replace('item-', '');
                if (firstItemHash) {
                    playAudio(firstItemHash);
                } else {
                    console.error("<?= $translationLines['no_mp3_items_error'];?>");
                }
            }

            changeLanguage(lang) {
                const expiryDate = new Date();
                expiryDate.setFullYear(expiryDate.getFullYear() + 10); // Set the expiration to 10 years from now
                document.cookie = "lang=" + lang + ";expires=" + expiryDate.toUTCString() + ";path=/";
                location.reload();
            }

            updateTimeInfo(hash) {
                const audioElement = document.getElementById('audio-' + hash);
                const timeInfo = document.querySelector('#item-' + hash + ' .time-info');

                if (audioElement && timeInfo) {
                    const duration = this.formatTime(Math.floor(audioElement.duration));
                    const currentTime = this.formatTime(Math.floor(audioElement.currentTime));
                    timeInfo.textContent = currentTime + ' / ' + duration;

                    localStorage[hash + '-progress'] = (Math.floor(audioElement.currentTime) / Math.floor(audioElement.duration)) * 100;
                    localStorage[hash + '-time'] = Math.floor(audioElement.currentTime);
                }
            }

            updateProgress(hash) {
                const audioElement = document.getElementById('audio-' + hash);
                const progress = document.querySelector('#item-' + hash + ' .progress-bar-inner');

                if (audioElement && progress) {
                    const percentage = (audioElement.currentTime / audioElement.duration) * 100;
                    progress.style.width = percentage + '%';
                }
            }

            formatTime(seconds) {
                let hours = Math.floor(seconds / 3600);
                let minutes = Math.floor((seconds % 3600) / 60);
                let secs = Math.floor(seconds % 60);
                return [hours, minutes, secs]
                    .map(v => v < 10 ? '0' + v : v)
                    .filter((v, i) => v !== '00' || i > 0)
                    .join(':');
            }

            toggleDescription(hash) {
                let descElement = document.getElementById('desc-' + hash);
                if (descElement) {
                    descElement.classList.toggle('description-opened');
                }
            }

            seekAudio(event, hash) {
                let audioElement = document.getElementById('audio-' + hash);
                let progressContainer = document.querySelector('#item-' + hash + ' .progress-bar');

                if (!audioElement || audioElement.readyState < 4) return;

                const rect = progressContainer.getBoundingClientRect();
                const percent = (event.clientX - rect.left) / rect.width;
                audioElement.currentTime = percent * audioElement.duration;

                this.updateTimeInfo(hash);
                this.updateProgress(hash);
            }

            // Additional methods like toggleDarkMode, changeLanguage, etc.
        }

        const audioPlayer = new AudioPlayer();

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