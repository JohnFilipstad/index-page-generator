
# 📂 Index Page Generator

Welcome to the **Index Page Generator** – a versatile and powerful PHP script designed to make directory navigation a breeze. Whether you're a developer needing an organized structure for your web directories or someone who wants to browse files with ease, this script is the perfect solution.

This README.md is available in multiple languages:

- [Norsk Bokmål](README.nb.md)
- Español - not yet available
- Français- not yet available
- Filipino - not yet available

## 🎉 What Is It?

The Index Page Generator is a PHP script that automatically creates `index.html` files for every directory within a specified path. These `index.html` files are beautifully structured and styled, providing a user-friendly grid layout that displays the contents of each directory with appropriate inline SVG icons for different file types.

### 🛠 Key Features

- **Recursive Directory Listings**: The script traverses all directories and subdirectories, generating `index.html` files for each, ensuring a complete and navigable file structure.
  
- **Inline SVG Icons**: Different file types and directories are represented with inline SVG icons, making it visually easier to identify the content at a glance.

- **Multilingual Support**: The script supports five languages: English, Norwegian, Filipino, Spanish, and French. It intelligently adapts to your preferred language, offering a truly international experience.

- **Dual Usage Modes**: Whether you prefer to run the script in a web environment or directly from the command line, the Index Page Generator has you covered. It provides real-time status updates and performance metrics in CLI mode.

- **Minimalist Design**: The generated `index.html` files are simple yet elegant, designed with responsiveness in mind to ensure they look great on any device.

## ✅ Requirements

Before you start using the **Index Page Generator**, make sure your environment meets the following requirements:

- **PHP 7.1 or higher**: The script requires PHP 7.1 or later. You can check your PHP version by running `php -v` in your terminal.
- **Web Server (Optional)**: For web use, ensure that you have a web server like Apache or Nginx running. The script should be placed in a directory served by your web server.
- **Command Line Interface (CLI) Access**: For CLI use, you need access to a terminal where you can execute PHP scripts.

### Optional Dependencies:

- **Composer (Optional)**: If you plan to extend the script or manage additional PHP dependencies, having Composer installed can be beneficial.
- **.htaccess (Optional)**: If you want to restrict access to the script or directories, you can use `.htaccess` for basic authentication or other security measures.

### Installation Notes:

- **File Permissions**: Ensure that the PHP script has the necessary permissions to read directories and write `index.html` files in the target directories.
- **PHP Extensions**: No additional PHP extensions are required beyond the standard PHP installation. However, ensure that common extensions like `mbstring` and `json` are enabled.

## 🚀 Getting Started

### Installation

1. **Download the Script**: Clone the repository to your local machine or directly download the `ipg.php` file.

2. **Place the Script**: Upload the `ipg.php` script to the root of the directory you wish to index.

3. **Run the Script**:
   - **Web Use**: Access the script via your browser. The script will generate `index.html` files for each directory. You can specify the language using the `?lang=xx` URL parameter (e.g., `?lang=nb` for Norsk Bokmål).
   - **CLI Use**: Run the script in your terminal:
     ```bash
     php ipg.php
     php ipg.php --lang=es
     ```
     The script uses English by default if the script is called without a parameter. Replace `es` with your desired language code (`en`, `nb`, `fil`, `es`, `fr`).

### Web Use Example

If your website is hosted at `http://yourdomain.com`, and you want the directory listings to be in Spanish, simply navigate to:

```
http://yourdomain.com/ipg.php?lang=es
```

The script will generate `index.html` files with directory listings in Spanish.

### CLI Use Example

If you prefer using the command line and want the listings in French, navigate to the directory where the script is located and run:

```bash
php ipg.php --lang=fr
```

### Language Support

The script supports the following languages:

- **English (en)** – Default
- **Norwegian (nb)**
- **Filipino (fil)**
- **Spanish (es)**
- **French (fr)**

You can switch languages by providing the appropriate language code either in the URL (`lang=xx`) or in the command line (`--lang=xx`).

## 📄 Perfect for GitHub Pages

The **Index Page Generator** is an excellent tool for enhancing your GitHub Pages experience. If you have a repository on GitHub Pages that lacks an `index.html` page, this script will automatically generate beautiful, structured directory listings for all your files and folders.

### Why Use It for GitHub Pages?

- **Automatic Directory Indexing**: No more blank directories! This script ensures every directory in your repository has a navigable `index.html`, listing all contained files and folders.
- **Simple Setup**: Just drop the script into your repository's root directory, and it will take care of the rest. Perfect for projects where you want to easily share files or provide access to resources.
- **Multilingual Support**: Whether your audience is global or local, the script's multilingual support (including English, Norwegian, Filipino, Spanish, and French) ensures your directory listings are accessible to a broad audience.
- **Visual Appeal**: With inline SVG icons and a clean, responsive design, the generated `index.html` pages look professional on both desktop and mobile devices.

Using this script with GitHub Pages transforms your repository from a collection of files into a well-organized, user-friendly resource hub. It's perfect for documentation sites, file repositories, or any project where users need easy access to multiple files and directories.

## 🌟 Why Use the Index Page Generator?

### Enhance Directory Navigation

This script is perfect for web developers, system administrators, and anyone who needs to navigate through large file structures. The organized, easy-to-navigate `index.html` files allow you to quickly find what you're looking for without diving into raw directory listings.

### Simplify File Management

By automatically generating clean, readable indexes, the script reduces the clutter and confusion often associated with large file repositories. It also visually enhances the browsing experience with icons that make file types instantly recognizable.

### Language Flexibility

Whether you're working on an international project or simply prefer to browse in your native language, the multilingual support ensures that the directory listings are accessible and understandable for a global audience.

## 📚 How It Works

The script recursively traverses each directory and subdirectory, ignoring hidden files and itself, to avoid recursion issues. It gathers file details such as name, last modified date, and size, and then generates a styled grid layout in the `index.html` file.

### Icon Representation
The script uses inline SVG icons to represent different file types:

- ![Folders](images/folder.svg) Folders
- ![Images](images/image.svg) Images
- ![Videos](images/video.svg) Videos
- ![Audio Files](images/audio.svg) Audio Files
- ![Documents](images/document.svg) Documents (PDF, Word, Excel, PowerPoint)
- ![Archives](images/archive.svg) Archives (ZIP, RAR, 7z, etc.)
- ![Text Files](images/text.svg) Text Files (TXT, MD, LOG)
- ![Code Files](images/code.svg) Code Files (HTML, CSS, JS)
- ![Generic Files](images/file.svg) Generic Files (for other types)

The icons add a visual dimension to the file listings, making it easier to navigate and understand the contents of each directory.

## 🔧 Customization

### Styling 

The generated `index.html` files are styled with a minimalist design using embedded CSS. If you wish to customize the appearance, feel free to modify the styles directly in the script. The design is responsive and works well on both desktop and mobile devices.

## 🚨 Note

Please be aware that running this script will **overwrite any existing `index.html` files** in the directories it processes. Make sure to back up important `index.html` files or rename them before running the script.

## 💡 Tips & Tricks

- **Automate**: Set up a cron job to run this script periodically, ensuring that your directory listings are always up to date.
- **Integration**: Integrate this script with your existing web projects to provide a user-friendly way to browse files directly from the browser.
- **Security**: If you only want the script to be accessible by specific users, consider using `.htaccess` for basic authentication.

## 📄 License
This project is licensed under the MIT License – see the `LICENSE` file for details. This means you are free to use, modify, and distribute the script in both personal and commercial projects.

## 🌍 Contributing
We welcome contributions! If you have ideas for new features or improvements, feel free to open an issue or submit a pull request. Let's make the Index Page Generator even better together.

## 🛠️ Support
If you encounter any issues or have any questions, please feel free to open an issue on GitHub or contact me directly. I'm here to help!

## 📚 Demo

See the [docs](./docs) for a demo. The script [ipg.php](./ipg.php) was used in the [docs-en](./docs/docs-en/) and [docs-nb](./docs/docs-nb) folders.


---
Thank you for checking out the Index Page Generator! Happy coding! 🚀

-- John Filipstad
