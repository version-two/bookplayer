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
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= $jsonData['title'] ?></title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400&family=Roboto+Mono:wght@100&display=swap"
              rel="stylesheet">
        <style>
            body {
                background-color : #121212;
                color            : #ffffff;
                font-family      : 'Poppins', sans-serif;
                margin           : 0;
                padding          : 0;
                height           : 100vh;
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
                font-weight   : 300;
                margin-bottom : 10px;
            }

            .page-subtitle {
                text-align    : center;
                color         : #adb5bd;
                font-size     : 1.2em;
                margin-bottom : 20px;
                font-weight   : 100;
            }

            .mp3-container {
                width            : 95%;
                max-width        : 600px;
                background-color : #1e1e1e;
                border-radius    : 10px;
                padding          : 20px;
                box-shadow       : 0 4px 8px rgba(0, 0, 0, 0.2);
            }

            .mp3-item {
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
                width            : 65%;
                background-color : #333333;
                border-radius    : 5px;
                overflow         : hidden;
            }

            .progress-bar-inner {
                height           : 10px;
                background-color : #007bff;
                width            : 0%;
            }

            @media (max-width : 600px) {
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
                margin-top : 0.5em;
                font-size  : 0.9em;
                color      : #888;
            }
        </style>
    </head>
    <body>
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
                echo '<div class="mp3-title">' . $title;
                if (!is_null($description)) {
                    echo ' <span class="expand-caret" onclick="toggleDescription(\'' . $hash . '\')">&#9660;</span>';
                    echo '<div class="mp3-description" id="desc-' . $hash . '" style="display:none;">' . htmlspecialchars($description) . '</div>';
                }
                echo '</div>';
                echo '<div class="mp3-controls">';
                echo '<button onclick="playAudio(\'' . $hash . '\')">Play</button>';
                echo '<div class="progress-bar" onclick="seekAudio(event, \'' . $hash . '\')"><div class="progress-bar-inner"></div></div>';
                echo '<div class="time-info">00:00 / ' . $formattedDuration . '</div>'; // Use the formatted duration here
                echo '</div>';
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
            if (descElement.style.display === "none") {
                descElement.style.display = "block";
            } else {
                descElement.style.display = "none";
            }
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

        // Call the function when page loads
        window.onload = restoreProgressAndTime;
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
 */
class MpegAudio
{
    /**
     * Holds MPEG data in memory
     * @var string
     */
    private $memory = "";

    /**
     * Holds an integer value pointing in a specific location in the memory
     * @var int
     */
    private $memoryPointer = 0;

    /**
     * Holds the length of the memory
     * @var int
     */
    private $memoryLength = 0;

    /**
     * Holds MPEG resource stream
     * @var resource
     */
    private $resource = null;

    /**
     * Holds an integer number representing the total number of MPEG audio frames
     * @var int
     */
    private $frames = -1;

    /**
     * Holds a float number representing the total duration of the MPEG audio data
     * @var double
     */
    private $duration = 0.0;

    /**
     * Holds an array of frame's starting offsets
     * @var int[]|array
     */
    private $frameOffsetTable = [];

    /**
     * Holds an array of frame's starting time
     * @var double[]|array
     */
    private $frameTimingTable = [];

    /**
     * Loads a MP3 file and returns a newly created MpegAudio object, or false on failure
     * @param string $path
     * @return bool|MpegAudio
     */
    public static function fromFile($path)
    {
        $inMemory = true;
        if ($inMemory) {
            return self::fromData(file_get_contents($path));
        } else {
            //return self::fromResource(fopen($path, "cb"));
        }
    }

    /**
     * Creates and returns a MpegAudio object and loads binary data, or false on failure
     * @param string $data
     * @return bool|MpegAudio
     */
    public static function fromData($data)
    {
        if (!is_string($data)) {
            return false;
        }
        $audio               = new MpegAudio();
        $audio->memory       = $data;
        $audio->memoryLength = strlen($audio->memory);
        return $audio;
    }

    /**
     * Reads a series of bytes from memory or resource
     * @param int $length
     * @param int $index
     * @return string
     */
    private function read($length = 0, $index = -1)
    {
        if ($this->resource === null) {
            if ($index < 0) {
                $index = $this->memoryPointer;
            }

            if ($length == 0) {
                $length = $this->memoryLength - $index;
            }

            $this->memoryPointer = min($this->memoryLength, $index + $length);
            if ($this->memoryPointer >= $this->memoryLength) {
                return false;
            }

            return substr($this->memory, $index, $length);
        } else {
            // TODO STREAM
        }
    }

    /**
     * Writes a series of bytes to the memory or resource, replacing older content or appending to the end
     * @param string $data
     * @param int    $index
     * @return int
     */
    private function write($data, $index = -1)
    {
        if ($this->resource === null) {
            $length = strlen($data);
            $this->slice($length, $index);
            return $this->insert($data, $index);
        } else {
            // TODO STREAM
        }
    }

    /**
     * Inserts a series of bytes to the memory or resource, increasing size
     * @param string $data
     * @param int    $index
     * @return int
     */
    private function insert($data, $index = -1)
    {
        if ($this->resource === null) {
            if ($index < 0) {
                $index = $this->memoryPointer;
            }
            $length              = strlen($data);
            $this->memoryPointer = $index + $length;
            $this->memory        = substr($this->memory, 0, $index) . $data . substr($this->memory, $index);
            $this->memoryLength  += strlen($data);
            return $length;
        } else {
            // TODO STREAM
        }
    }

    /**
     * Removing parts of the memory or resource, decreasing size
     * @param int $length
     * @param int $index
     * @return int
     */
    private function slice($length = 0, $index = -1)
    {
        if ($this->resource === null) {
            if ($index < 0) {
                $index = $this->memoryPointer;
            }
            if ($length == 0) {
                $length = $this->memoryLength - $index;
            }
            $this->memoryPointer = $index;
            $length              = max(min($this->memoryLength - $index, $length), 0);
            $this->memory        = substr($this->memory, 0, $index) . substr($this->memory, $index + $length);
            $this->memoryLength  -= $length;
            return $length;
        } else {
            // TODO STREAM
        }
    }

    /**
     * Seeking pointer to a specific location, or returns the current pointer location
     * @param int $index
     * @return int|bool
     */
    private function seek($index = -1)
    {
        if ($index < 0) {
            if ($this->resource === null) {
                return $this->memoryPointer;
            } else {
                // TODO STREAM
            }
        }
        if ($this->resource === null) {
            $this->memoryPointer = $index;
            return true;
        } else {
            // TODO STREAM
        }
    }

    /**
     * Creates an empty MPEG audio class
     */
    public function __construct()
    {
        $this->reset();
        $this->memory = "";
    }

    /**
     * Resets all extracted data and marks them for recalculation
     */
    private function reset()
    {
        $this->frames           = -1;
        $this->frameTimingTable = [];
        $this->frameOffsetTable = [];
        $this->duration         = 0.0;
    }

    /**
     * Calculate and extract MPEG audio information
     */
    private function analyze()
    {
        $offset                 = $this->getStart();
        $this->frames           = 0;
        $this->frameOffsetTable = [];
        $this->frameTimingTable = [];
        $this->duration         = 0.0;
        if ($offset !== false) {
            while (true) {
                $frameHeader = $this->readFrameHeader($offset);
                if ($frameHeader === false) {
                    // Try recovery
                    $offset = $this->getStart($offset);
                    if ($offset !== false) {
                        continue;
                    }
                    break;
                }
                $this->duration                        += $frameHeader->getDuration();
                $this->frameOffsetTable[$this->frames] = $frameHeader->getOffset();
                $this->frameTimingTable[$this->frames] = $this->duration;
                $this->frames++;
                $offset = $frameHeader->getOffset() + $frameHeader->getLength();
                unset($frameHeader);
            }
        }
    }

    /**
     * Calculates the starting offset of the first frame after the specified offset
     * @param int $offset
     * @return bool|int
     */
    private function getStart($offset = 0)
    {
        $offset--;
        while (true) {
            $offset++;
            $byte = $this->read(1, $offset);
            if ($byte === false) {
                return false;
            }
            if ($byte != chr(255)) {
                continue;
            }
            $frameHeader = $this->readFrameHeader($offset);
            if ($frameHeader === false) {
                continue;
            }
            $frameHeader = $this->readFrameHeader($frameHeader->getOffset() + $frameHeader->getLength());
            if ($frameHeader === false) {
                continue;
            }
            return $offset;
        }
    }

    /**
     * Reads a frame's header and returns a MpegAudioFrameHeader object
     * @param int $offset
     * @return bool|MpegAudioFrameHeader
     */
    private function readFrameHeader($offset)
    {
        $bytes = $this->read(4, $offset);
        return MpegAudioFrameHeader::tryParse($bytes, $offset);
    }

    /**
     * Saves this MPEG audio to a file, returns this object
     * @param string $path
     * @return MpegAudio
     */
    public function saveFile($path)
    {
        if ($this->resource === null) {
            file_put_contents($path, $this->memory);
        } else {
            fflush($this->resource);
            // TODO COPY STREAM
        }
        return $this;
    }

    /**
     * Closes all resources and frees the memory, returns MPEG audio as binary string, or a boolean value indicating the operation success
     * @return bool|string
     */
    public function close()
    {
        if ($this->resource === null) {
            $data                = $this->memory;
            $this->memory        = "";
            $this->memoryLength  = 0;
            $this->memoryPointer = 0;
            return $data;
        }
        if ($this->resource !== null && fclose($this->resource)) {
            $this->resource = null;
            return true;
        }
        return false;
    }

    /**
     * Gets the number of frames in this MPEG audio
     * @return int
     */
    public function getFrameCounts()
    {
        if ($this->frames < 0) {
            $this->analyze();
        }
        return $this->frames;
    }

    /**
     * Gets the total duration of this MPEG audio in seconds
     * @return double
     */
    public function getTotalDuration()
    {
        if ($this->getFrameCounts()) {
            return $this->duration;
        }
        return 0.0;
    }

    /**
     * Gets a MpegAudioFrameHeader object reperesenting the header of an MPEG audio frame, or false or failure
     * @param int $index
     * @return bool|MpegAudioFrameHeader
     */
    public function getFrameHeader($index)
    {
        if ($index >= 0 && $index < $this->getFrameCounts()) {
            return $this->readFrameHeader($this->frameOffsetTable[$index]);
        }
        return false;
    }

    /**
     * Gets a frame's data (including header) as a binary string, or false or failure
     * @param int $index
     * @return bool|string
     */
    public function getFrameData($index)
    {
        $frameHeader = $this->getFrameHeader($index);
        if ($frameHeader !== false) {
            return $this->read($frameHeader->getOffset(), $frameHeader->getLength());
        }
        return false;
    }

    /**
     * Removes a set of frames from this MPEG audio, returns this object
     * @param int $index
     * @param int $count
     * @return MpegAudio
     */
    public function removeFrame($index, $count = 1)
    {
        if ($count < 0) {
            $index += $count;
            $count *= -1;
        }
        if ($index < 0 || $index >= $this->getFrameCounts()) {
            return $this;
        }
        $count = min($this->getFrameCounts() - $index, $count);
        if ($count == 0) {
            return $this;
        }
        $firstFrameHeader = $this->getFrameHeader($index);
        $lastFrameHeader  = $this->getFrameHeader($index + ($count - 1));
        $this->slice(($lastFrameHeader->getOffset() + $lastFrameHeader->getLength()) - $firstFrameHeader->getOffset(), $firstFrameHeader->getOffset());
        $this->reset();
        return $this;
    }

    /**
     * Appends a potion of a MPEG audio to this MPEG audio, returns this object
     * @param MpegAudio $srcAudio
     * @param int       $index
     * @param int       $length
     * @return MpegAudio
     */
    public function append(MpegAudio $srcAudio, $index = 0, $length = -1)
    {
        if ($index < 0 || $index >= $srcAudio->getFrameCounts()) {
            return $this;
        }
        if ($length < 0) {
            $length = $srcAudio->getFrameCounts() - $index;
        }
        $length = min($srcAudio->getFrameCounts() - $index, $length);

        $srcFirstFrameHeader = $srcAudio->getFrameHeader($index);
        $srcLastFrameHeader  = $srcAudio->getFrameHeader($index + ($length - 1));
        $data                =
            $srcAudio->read(($srcLastFrameHeader->getOffset() + $srcLastFrameHeader->getLength()) - $srcFirstFrameHeader->getOffset(), $srcFirstFrameHeader->getOffset());
        if ($data) {
            $endOfStream = 0;
            if ($this->getFrameCounts() > 0) {
                $frameHeader = $this->getFrameHeader($this->getFrameCounts() - 1);
                if ($frameHeader !== false) {
                    $endOfStream = $frameHeader->getOffset() + $frameHeader->getLength();
                }
            }
            $this->insert($data, $endOfStream);
            $this->analyze();
        }
        return $this;
    }

    /**
     * Trims this MPEG audio by removing all frames except the parts that are selected by time in seconds, returns this object
     * @param int $startTime
     * @param int $duration
     * @return MpegAudio
     */
    public function trim($startTime, $duration = 0)
    {
        if ($startTime < 0) {
            $startTime = $this->getTotalDuration() + $startTime;
        }
        if ($duration <= 0) {
            $duration = $this->getTotalDuration() - $startTime;
        }
        $endTime    = min($startTime + $duration, $this->getTotalDuration());
        $startIndex = 0;
        $endIndex   = 0;
        foreach ($this->frameTimingTable as $frameIndex => $frameTiming) {
            if ($frameTiming <= $startTime) {
                $startIndex = $frameIndex;
            } else {
                if ($frameTiming >= $endTime) {
                    $endIndex = $frameIndex;
                    break;
                }
            }
        }
        $this->removeFrame($endIndex, $this->getFrameCounts() - $endIndex);
        $this->removeFrame(0, $startIndex);
        return $this;
    }

    /**
     * Gets metadata stored at the begining of the MPEG audio as a binary string, or false on failure
     * @return bool|string
     */
    public function getBeginingTags()
    {
        $start = $this->getStart();
        if ($start === false) {
            return false;
        }
        return $this->read($start, 0);
    }

    /**
     * Gets metadata stored at the end of the MPEG audio as a binary string, or false on failure
     * @return bool|string
     */
    public function getEndingTags()
    {
        $frames = $this->getFrameCounts();
        if ($frames === 0) {
            return false;
        }
        $frame = $this->getFrameHeader($frames - 1);
        if ($frame === false) {
            return false;
        }
        return $this->read(0, $frame->getOffset() + $frame->getLength());
    }

    /**
     * Removes metadata stored at the begining and the end of the MPEG audio, returns this object
     * @return MpegAudio
     */
    public function stripTags()
    {
        $frames = $this->getFrameCounts();
        if ($frames > 0) {
            $frame = $this->getFrameHeader($frames - 1);
            if ($frame !== false) {
                $this->slice(0, $frame->getOffset() + $frame->getLength());
            }
        }
        $start = $this->getStart();
        if ($start !== false && $start > 0) {
            $this->slice($start, 0);
        }
        $this->reset();
        return $this;
    }
}


/**
 * This class represents a MPEG audio frame's header
 * @author         Soroush Falahati https://falahati.net
 * @copyright      Soroush Falahati (C) 2017
 * @license        LGPL v3 https://www.gnu.org/licenses/lgpl-3.0.en.html
 * @link           https://github.com/falahati/PHP-MP3
 */
class MpegAudioFrameHeader
{
    /**
     * MPEG Audio Version 1
     */
    const Version_10 = 1;

    /**
     * MPEG Audio Version 2
     */
    const Version_20 = 2;

    /**
     * MPEG Audio Version 3
     */
    const Version_25 = 3;

    /**
     * MPEG Audio Profile 1
     */
    const Profile_1 = 1;

    /**
     * MPEG Audio Profile 2
     */
    const Profile_2 = 2;

    /**
     * MPEG Audio Profile 3
     */
    const Profile_3 = 3;

    /**
     * MPEG Audio Stereo Mode
     */
    const Mode_Stereo = 0;

    /**
     * MPEG Audio Joint Stereo Mode
     */
    const Mode_JointStereo = 1;

    /**
     * MPEG Audio Dual Channel Mono Mode
     */
    const Mode_DualChannel = 2;

    /**
     * MPEG Audio Single Channel Mono Mode
     */
    const Mode_SingleChannel = 3;

    /**
     * MPEG Audio Profile 3 Intensity Stereo Disabled
     */
    const IntensityStereo_Disable = 0;

    /**
     * MPEG Audio Profile 3 Intensity Stereo Auto Frequency Selection
     */
    const IntensityStereo_Auto = 1;

    /**
     * MPEG Audio Profile 1 & Profile 2 Intensity Stereo Frequency Bands 4 to 31
     */
    const IntensityStereo_Bands4_31 = 2;

    /**
     * MPEG Audio Profile 1 & Profile 2 Intensity Stereo Frequency Bands 8 to 31
     */
    const IntensityStereo_Bands8_31 = 3;

    /**
     * MPEG Audio Profile 1 & Profile 2 Intensity Stereo Frequency Bands 12 to 31
     */
    const IntensityStereo_Bands12_31 = 4;

    /**
     * MPEG Audio Profile 1 & Profile 2 Intensity Stereo Frequency Bands 16 to 31
     */
    const IntensityStereo_Bands16_31 = 5;

    /**
     * Holds the bit rate of the frame
     * @var int
     */
    private $bitRate = 0;

    /**
     * Holds the sample rate of the frame
     * @var int
     */
    private $sampleRate = 0;

    /**
     * Holds the MPEG audio version of the frame
     * @var int
     */
    private $version = -1;

    /**
     * Holds the MPEG audio profile of the frame
     * @var int
     */
    private $profile = -1;

    /**
     * Holds the estimated duration of this frame
     * @var double
     */
    private $duration = 0.0;

    /**
     * Holds the frame's data offset in MPEG audio
     * @var int
     */
    private $offset = 0;

    /**
     * Holds the frame's data length in MPEG audio
     * @var int
     */
    private $length = 0;

    /**
     * Holds the frame's ending padding in bytes
     * @var int
     */
    private $padding = 0;

    /**
     * Holds the frame's error protection status
     * @var bool
     */
    private $errorProtection = false;

    /**
     * Holds the frame's extra information status
     * @var bool
     */
    private $privateBit = false;

    /**
     * Holds the frame's copyrighted work bit status
     * @var bool
     */
    private $copyrighted = false;

    /**
     * Holds the frame's copyrighted work originality bit status
     * @var bool
     */
    private $original = false;

    /**
     * Holds the frame's channels mode
     * @var int
     */
    private $mode = self::Mode_Stereo;

    /**
     * Holds the frame's middle-side stereo joining availability status
     * @var bool
     */
    private $middleSideStereoJoining = false;

    /**
     * Holds the frame's intensity stereo operation mode
     * @var int
     */
    private $intensityStereoMode = self::IntensityStereo_Disable;

    /**
     * Holds the list of every byte along with their equivalent binary representation
     * @var array
     */
    private static $binaryTable = [];

    /**
     * Holds the list of standard bit rates for MPEG audio
     * @var array
     */
    private static $bitRateTable = [];

    /**
     * Holds the list of standard sample rates for MPEG audio
     * @var array
     */
    private static $sampleRateTable = [];

    /**
     * Gets the frame's bit rate in bps
     * @return int
     */
    public function getBitRate()
    {
        return $this->bitRate;
    }

    /**
     * Gets the frame's sample rate in Hz
     * @return int
     */
    public function getSampleRate()
    {
        return $this->sampleRate;
    }

    /**
     * Gets the frame's MPEG audio version number
     * @return int
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Gets the frame's MPEG audio layer profile number
     * @return int
     */
    public function getLayerProfile()
    {
        return $this->profile;
    }

    /**
     * Gets the frame's estimated duration
     * @return float
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Gets the frame's data offset in MPEG audio
     * @return int
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * Gets the frame's data length in MPEG audio
     * @return int
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * Gets the frame's ending padding in bytes
     * @return int
     */
    public function getPadding()
    {
        return $this->padding;
    }

    /**
     * Gets the frame's error protection status
     * @return bool
     */
    public function isErrorProtectionEnable()
    {
        return $this->errorProtection;
    }

    /**
     * Gets the frame's private bit information status
     * @return bool
     */
    public function isPrivateBitActive()
    {
        return $this->privateBit;
    }

    /**
     * Gets the frame's copyrighted work bit status
     * @return bool
     */
    public function isCopyrighted()
    {
        return $this->copyrighted;
    }

    /**
     * Gets the frame's copyrighted work originality bit status
     * @return bool
     */
    public function isOriginal()
    {
        return $this->original;
    }

    /**
     * Gets the frame's channels mode
     * @return int
     */
    public function getChannelMode()
    {
        return $this->mode;
    }

    /**
     * Gets the frame's middle side stereo joining availability status
     * @return bool
     */
    public function isMiddleSideStereoJoiningEnable()
    {
        return $this->middleSideStereoJoining;
    }

    /**
     * Gets the frame's intensity stereo mode
     * @return int
     */
    public function getIntensityStereoMode()
    {
        return $this->intensityStereoMode;
    }

    /**
     * Creates a new instance of this class, also fills the binary table for later use
     */
    private function __construct()
    {
        if (!self::$binaryTable) {
            for ($i = 0; $i < 256; $i++) {
                self::$binaryTable[chr($i)] = sprintf('%08b', $i);
            }
        }
        if (!self::$bitRateTable) {
            self::$bitRateTable = [
                '0000' => [0, 0, 0, 0, 0],
                '0001' => [32, 32, 32, 32, 8],
                '0010' => [64, 48, 40, 48, 16],
                '0011' => [96, 56, 48, 56, 24],
                '0100' => [128, 64, 56, 64, 32],
                '0101' => [160, 80, 64, 80, 40],
                '0110' => [192, 96, 80, 96, 48],
                '0111' => [224, 112, 96, 112, 56],
                '1000' => [256, 128, 112, 128, 64],
                '1001' => [288, 160, 128, 144, 80],
                '1010' => [320, 192, 160, 160, 96],
                '1011' => [352, 224, 192, 176, 112],
                '1100' => [384, 256, 224, 192, 128],
                '1101' => [416, 320, 256, 224, 144],
                '1110' => [448, 384, 320, 256, 160],
                '1111' => [-1, -1, -1, -1, -1],
            ];
        }
        if (!self::$sampleRateTable) {
            self::$sampleRateTable = [
                self::Version_10 => [
                    '00' => 44100,
                    '01' => 48000,
                    '10' => 32000,
                    '11' => 0,
                ],
                self::Version_20 => [
                    '00' => 22050,
                    '01' => 24000,
                    '10' => 16000,
                    '11' => 0,
                ],
                self::Version_25 => [
                    '00' => 11025,
                    '01' => 12000,
                    '10' => 8000,
                    '11' => 0,
                ],
            ];
        }
    }

    /**
     * Tries to parse and return a new MpegAudioFrameHeader object from the provided data, false on failure
     * @param string $headerBytes
     * @param int    $offset
     * @return bool|MpegAudioFrameHeader
     */
    public static function tryParse($headerBytes, $offset)
    {
        $frame         = new self();
        $frame->offset = $offset;

        // -------------------------------------------------------------------
        // Converting bytes to their formatted binary string
        $headerBits = [];
        for ($i = 0; $i < strlen($headerBytes); $i++) {
            $headerBits[] = self::$binaryTable[$headerBytes[$i]];
        }

        // -------------------------------------------------------------------
        // Check header marker
        if (count($headerBits) < 4 || $headerBits[0] !== '11111111' || substr($headerBits[1], 0, 3) !== '111') {
            return false;
        }

        // -------------------------------------------------------------------
        // Get version
        switch (substr($headerBits[1], 3, 2)) {
            case '01':
                // Reserved
                return false;
            case '00':
                $frame->version = self::Version_25;
                break;
            case '10':
                $frame->version = self::Version_20;
                break;
            case '11':
                $frame->version = self::Version_10;
                break;
        }

        // -------------------------------------------------------------------
        // Get profile
        switch (substr($headerBits[1], 5, 2)) {
            case '01':
                $frame->profile = self::Profile_3;
                break;
            case '00':
                // Reserved
                return false;
            case '10':
                $frame->profile = self::Profile_2;
                break;
            case '11':
                $frame->profile = self::Profile_1;
                break;
        }

        // -------------------------------------------------------------------
        // Get error protection bit
        $frame->errorProtection = !!(substr($headerBits[1], 7, 1));

        // -------------------------------------------------------------------
        // Get bitrate
        $frame->bitRate = -1;
        $bitRateIndex   = substr($headerBits[2], 0, 4);
        if ($frame->version == self::Version_10) {
            switch ($frame->profile) {
                case self::Profile_1:
                    $frame->bitRate = self::$bitRateTable[$bitRateIndex][0];
                    break;
                case self::Profile_2:
                    $frame->bitRate = self::$bitRateTable[$bitRateIndex][1];
                    break;
                case self::Profile_3:
                    $frame->bitRate = self::$bitRateTable[$bitRateIndex][2];
                    break;
            }
        } else {
            switch ($frame->profile) {
                case self::Profile_1:
                    $frame->bitRate = self::$bitRateTable[$bitRateIndex][3];
                    break;
                case self::Profile_2:
                case self::Profile_3:
                    $frame->bitRate = self::$bitRateTable[$bitRateIndex][4];
                    break;
            }
        }
        if ($frame->bitRate <= 0) {
            // Invalid value or bitrate needs calculation
            return false;
        }
        // Convert kbps to bps
        $frame->bitRate *= 1000;

        // -------------------------------------------------------------------
        // Get sample rate
        $frame->sampleRate = self::$sampleRateTable[$frame->version][substr($headerBits[2], 4, 2)];
        if ($frame->sampleRate <= 0) {
            // Invalid sample rate value
            return false;
        }

        // -------------------------------------------------------------------
        // Get frame padding
        $frame->padding = substr($headerBits[2], 6, 1) ? 1 : 0;

        // -------------------------------------------------------------------
        // Get protection bit
        $frame->privateBit = !!(substr($headerBits[2], 7, 1));


        // -------------------------------------------------------------------
        // Get audio mode
        switch (substr($headerBits[3], 0, 2)) {
            case '00':
                $frame->mode = self::Mode_Stereo;
                break;
            case '01':
                $frame->mode = self::Mode_JointStereo;
                break;
            case '10':
                $frame->mode = self::Mode_DualChannel;
                break;
            case '11':
                $frame->mode = self::Mode_SingleChannel;
                break;
        }
        if ($frame->profile == self::Profile_1 || $frame->profile == self::Profile_2) {
            $frame->middleSideStereoJoining = false;
            switch (substr($headerBits[3], 2, 2)) {
                case '00':
                    $frame->intensityStereoMode = self::IntensityStereo_Bands4_31;
                    break;
                case '01':
                    $frame->intensityStereoMode = self::IntensityStereo_Bands8_31;
                    break;
                case '10':
                    $frame->intensityStereoMode = self::IntensityStereo_Bands12_31;
                    break;
                case '11':
                    $frame->intensityStereoMode = self::IntensityStereo_Bands16_31;
                    break;
            }
        } else {
            if ($frame->profile == self::Profile_3) {
                $frame->intensityStereoMode     =
                    substr($headerBits[3], 2, 1) ? self::IntensityStereo_Auto : self::IntensityStereo_Disable;
                $frame->middleSideStereoJoining = !!(substr($headerBits[3], 3, 1));
            }
        }

        // -------------------------------------------------------------------
        // Get copyright information
        $frame->copyrighted = !!(substr($headerBits[3], 4, 4));
        $frame->original    = !!(substr($headerBits[3], 5, 1));

        // -------------------------------------------------------------------
        // Calculate frame length
        if ($frame->profile == self::Profile_1) {
            $frame->length = (((12 * $frame->bitRate) / $frame->sampleRate) + $frame->padding) * 4;
        } else {
            if ($frame->profile == self::Profile_2 || $frame->profile == self::Profile_3) {
                $frame->length = ((144 * $frame->bitRate) / $frame->sampleRate) + $frame->padding;
            }
        }
        $frame->length = floor($frame->length);
        if ($frame->length <= 0) {
            // Invalid frame length
            return false;
        }

        // -------------------------------------------------------------------
        // Calculate frame duration
        $frame->duration = $frame->length * 8 / $frame->bitRate;

        // -------------------------------------------------------------------
        // Return result
        return $frame;
    }
}