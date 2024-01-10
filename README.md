# BookPlayer: A PHP Web Audio Player

## Overview

BookPlayer is a web-based audio player built with PHP, designed to efficiently manage and play MP3 files directly from
your browser. It's ideal for audiobooks, music libraries, language learning materials, and more. The application is
equipped with features like volume and speed control, progress tracking, and language selection, offering a versatile
listening experience.

### Features

- **MP3 Playback:** Plays MP3 files seamlessly.
- **Dynamic Speed Control:** Adjust playback speed to your preference.
- **Volume Control:** Easy volume adjustment with a slider.
- **Progress Tracking:** Remembers playback position for each file.
- **Language Selection:** Supports multiple languages for the interface.
- **Responsive Design:** Optimized for desktop and mobile devices.
- **Listened Marking:** Mark files as listened or not listened.
- **Dark Mode Interface:** Comfortable for night-time listening.

## Installation

1. **Download index.php:**
   Just download the `index.php` file.

2. **Directory Setup:**
   Place the script in a PHP-supported server environment.

3. **MP3 files:**
   Drop some .mp3 files in the same directory and access the script.

## Customization

### Editing `page.json` for Default Settings

- **Default Language, Title, and Subtitle:**
  Modify `page.json` in the `.metadata` directory to set these defaults:
    - `lang`: Default language code (e.g., "en").
    - `title`: Page title.
    - `subtitle`: Subtitle (supports HTML content).

### Editing Metadata Files for MP3 Files

- **Custom Titles and Descriptions:**
  Each MP3 file can have a metadata file `[filename].json` in `.metadata`. 
  These files are generated automatically on page-load. 
  Edit these files to set custom titles and descriptions (HTML supported) for each MP3.
  ```json
  {
  "name"       : "filename.mp3",        // Name of the file
  "size"       : 1234567,               // Size of the file in bytes
  "hash"       : "md5hash",             // MD5 hash of the file
  "duration"   : 360,                   // Pre-calculated duration of the file in seconds 
  "title"      : "Optional Title",      // [Optional] Title of the file such as chapter or custom name to display
  "description": "Optional Description" // [Optional] Description of the chapter / mp3 file.
  }
  ```
- **Automatic Regeneration of Metadata:**
  If an MP3 file changes, its metadata file is regenerated to update the duration. Custom titles and descriptions are
  retained.

### Creating Custom Translation Files

- **Creating and Registering:**
  Create a JSON file per language in `.metadata/lang` and register it in the `$settings` array in the PHP script.

## Usage

- **Accessing the Player:**
  Open `index.php` in a browser to access BookPlayer.
- **Adding MP3 Files:**
  Place MP3 files in the same directory as the script.
- **Playing Audio:**
  Click the 'Play' button next to an audio file or global 'Play / Resume'  button to start / resume playback. Your progress on each file is saved to LocalStorage 
- **Adjusting Volume and Speed:**
  Use the sliders in the settings modal. This setting is stored in LocalStorage.
- **Language Selection:**
  Choose a language from the settings modal.
- **Progress Tracking:**
  Playback progress is saved automatically.
- **Marking Files as Listened:**
  Mark files using the listened/not listened buttons. This data is stored in LocalStorage.

## Contributing

Contributions are welcome. Whether it's bug fixes, feature additions, or documentation improvements.

1. **Fork and Branch:**
   Create a fork and make your changes in a new branch.
2. **Pull Request:**
   Submit your changes for review.

## License

This project is under the [APACHE 2.0 License](LICENSE).

---

Enjoy BookPlayer, your customizable web-based audio player! 🎧
