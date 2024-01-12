class AudioPlayer {
    options;
    translations;

    constructor(options = {}, translations = {}) {
        let defaultOptions = {};

        Object.assign(this.options, defaultOptions, options);
        this.currentSpeed = 1;
        this.currentlyPlaying = false;
        this.currentHash = '';
        this.globalVolume = 1;
        this.timeUpdateInterval = null;
        this.translations = translations

        this.initializeEventListeners();
        this.restoreSettings();
        if (this.options['audioFiles'] > 0) {
            this.updatePlayResumeButton();
            this.updatePlayResumeButtonIcon();
        }
    }

    initializeEventListeners() {
        window.onload = () => this.restoreSettings();
        window.onresize = () => this.updatePlayResumeButtonIcon();
        if (this.options['audioFiles'] > 0) {
            document.getElementById('volumeControl').addEventListener('input', this.handleVolumeChange.bind(this));
            document.getElementById('speedSlider').addEventListener('input', this.handleSpeedChange.bind(this));
            document.getElementById('resetSpeedButton').addEventListener('click', this.resetSpeed.bind(this));
            document.getElementById('playResumeButton').onclick = () => this.playOrResume();
        }
        document.getElementById('settingsModal').onclick = this.handleModalClick.bind(this);
        document.getElementById('settings-icon').onclick = () => this.openModal();
    }

    restoreSettings() {
        if (this.options['audioFiles'] > 0) {
            this.restoreProgressAndTime();
            this.restoreVolumeSetting();
            this.restoreListenedToFiles();
            this.restoreSpeedSetting();
            this.updatePlayResumeButtonIcon();
        }
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
            console.error(this.translations['play_audio_error'], encodedFilename);
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
                    playButton.textContent = this.translations['stop'];
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
                    console.error(this.translations['playback_error'], error);
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
            playButton.textContent = this.translations['play'];
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
        let buttonText = this.translations['play_resume_button_text_beginning'];
        if (lastPlayedHash) {
            const lastAudioElement = document.getElementById('audio-' + lastPlayedHash);
            if (lastAudioElement) {
                if (!lastAudioElement.paused && !lastAudioElement.ended) {
                    // If currently playing
                    buttonText = this.translations['pause'];
                } else if (lastAudioElement.paused && lastAudioElement.currentTime > 0 && !lastAudioElement.ended) {
                    // If paused, has progress, and not ended
                    buttonText = buttonText = this.translations['resume_playback_button_text'];
                } else {
                    buttonText = buttonText = this.translations['resume_playback_button_text'];
                }
            } else {
                // If lastPlayedHash exists but corresponding audio element not found
                buttonText = buttonText = this.translations['play_resume_button_text_beginning'];
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
                if (playButton) playButton.textContent = this.translations['play'];
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
            this.playAudio(firstItemHash);
        } else {
            console.error(this.translations['no_mp3_items_error']);
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