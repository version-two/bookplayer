<?php


function checkForUpdate($settings)
{
    $lastCheck   = $settings['last_check'] ?? 0;
    $currentTime = time();

    if ($settings['auto_update'] && $currentTime - $lastCheck > 3600) {
        $context           = stream_context_create(['http' => ['header' => 'User-Agent: PHP']]);
        $githubFileContent =
            file_get_contents("https://github.com/version-two/bookplayer/releases/latest/download/index.php", false, $context);

        if ($githubFileContent === false) {
            //echo "Error fetching file from GitHub.";
        } else {
            $localFileContent = file_get_contents(__FILE__);

            if ($localFileContent === false) {
                //echo "Error reading local file.";
            } elseif ($githubFileContent !== $localFileContent) {
                // Update the file
                file_put_contents(__FILE__, $githubFileContent);
                //echo "Update completed. Please reload the page.";
                header("Refresh:0");
                exit;
            }
        }

        // Update the last check time
        $settings['last_check'] = $currentTime;
        $json                   = json_encode($settings);
        file_put_contents('.metadata/page.json', $json);
    }
}

function initFilesIfNotPresent()
{
    if (!is_dir('.metadata')) {
        mkdir('.metadata');

        initMetaDataFolder();
        initPageJson();
    }
    if (!is_dir('.metadata/lang')) {
        mkdir('.metadata/lang');
    }

    if (!file_exists('.metadata/page.json')) {
        initPageJson();
    }
    if (!file_exists('.metadata/lang/en.json')) {
        file_put_contents('.metadata/lang/en.json', json_encode(["settings_title" => "Settings", "language_title" => "Language:", "speed_title" => "Speed:", "volume_control_label" => "Volume control:", "speed_label" => "Speed: ", "reset_button" => "Reset", "play" => "Play", "stop" => "Stop", "pause" => "Pause", "play_resume_button_text_beginning" => "Play from beginning", "resume_playback_button_text" => "Resume playback", "mark_as_listened_tooltip" => "Mark as listened to", "mark_as_not_listened_tooltip" => "Mark as not listened to", "play_audio_error" => "Required elements not found for:", "no_mp3_items_error" => "No MP3 items found on the page", "playback_error" => "Error attempting to play audio:",]), true);
    }
    if (!file_exists('.metadata/lang/sk.json')) {
        file_put_contents('.metadata/lang/sk.json', json_encode(["settings_title" => "Nastavenia", "language_title" => "Jazyk:", "speed_title" => "Rýchlosť:", "volume_control_label" => "Ovládanie hlasitosti:", "speed_label" => "Rýchlosť prehrávania: ", "reset_button" => "Reset", "play" => "Prehrať", "stop" => "Zastaviť", "pause" => "Pauza", "play_resume_button_text_beginning" => "Prehrať od začiatku", "resume_playback_button_text" => "Pokračovať v prehrávaní", "mark_as_listened_tooltip" => "Označiť ako vypočuté", "mark_as_not_listened_tooltip" => "Označiť ako nevypočuté", "play_audio_error" => "Požadované prvky neboli nájdené pre:", "no_mp3_items_error" => "Na stránke neboli nájdené žiadne MP3 položky", "playback_error" => "Chyba pri pokuse o prehranie zvuku:"]), true);
    }
}

function scanDirectories($baseDir, $relativePath = '')
{
    $directories = [];

    // Recursive function to scan subdirectories
    $scanSubDirectories = function ($dirPath) use (&$scanSubDirectories) {
        $subDirs   = [];
        $dirHandle = opendir($dirPath);

        while (false !== ($entry = readdir($dirHandle))) {
            if ($entry != "." && $entry != ".." && is_dir($dirPath . '/' . $entry)) {
                $metadataPath = $dirPath . '/' . $entry . '/.metadata/page.json';
                if (file_exists($metadataPath)) {
                    $pageJsonContent = json_decode(file_get_contents($metadataPath), true);
                    $subDirs[$entry] = [
                        'content'   => $pageJsonContent,
                        'directory' => $dirPath . '/' . $entry,
                        'subDirs'   => $scanSubDirectories($dirPath . '/' . $entry),
                    ];
                } else {
                    // Recursively scan deeper subdirectories
                    $deepSubDirs = $scanSubDirectories($dirPath . '/' . $entry);
                    if (!empty($deepSubDirs)) {
                        $subDirs[$entry] = [
                            'directory' => $dirPath . '/' . $entry,
                            'subDirs'   => $deepSubDirs,
                        ];
                    }
                }
            }
        }
        closedir($dirHandle);

        return $subDirs;
    };

    // Start scanning from the base directory
    return $scanSubDirectories($baseDir . '/' . $relativePath);
}


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
    file_put_contents('.metadata' . DIRECTORY_SEPARATOR . 'page.json', '{"lang": "en","title": "BookPlayer","subtitle": "by <a href=\"https://v2.sk/\" target=\"_blank\" title=\"Version Two - versiontwo.sk - Websites, mobile apps, custom systems ...\">v2.sk</a>"}');
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

?>