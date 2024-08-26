<?php

/**
 * Index Page Generator
 * A Recursive Directory Listing Script
 * with Inline SVG Icons and Multilingual Support
 *
 * Filename: ipg.php
 * Author: John Filipstad
 * Version: 1.0
 *
 * Description:
 * This PHP script generates an `index.html` file for each directory within the
 * specified path. Each `index.html` provides a structured and styled grid
 * layout that mimics a table, listing the contents of the directory with
 * inline SVG icons representing different file types. It supports multiple
 * languages for directory listings: English, Norwegian, Filipino, Spanish, and French.
 *
 * Features:
 * - Recursive generation of directory listings.
 * - Inclusion of inline SVG icons for various file types and directories.
 * - Multilingual support with options for English, Norwegian, Filipino, Spanish, and French.
 * - Option to run in a console environment, providing status updates and
 *   performance metrics.
 *
 * How to Use:
 * - For web use: Place this script in the root directory you want to list. It
 *   will generate `index.html` files in each directory, creating a navigable
 *   directory structure. You can specify the language by appending `?lang=xx`
 *   to the URL, where `xx` is the language code (`en` for English, `nb` for Norwegian, 
 *   `fil` for Filipino, `es` for Spanish, `fr` for French). 
 *   Example: `http://yourdomain.com/ipg.php?lang=es`
 *
 * - For CLI use: Run the script with an optional `--lang` argument to specify
 *   the language. 
 *   Example: `php ipg.php --lang=en` for English, 
 *   `php ipg.php --lang=nb` for Norwegian, `php ipg.php --lang=fil`
 *   for Filipino, `php ipg.php --lang=es` for Spanish, or 
 *   `php ipg.php --lang=fr` for French.
 *
 * Note:
 * - The script ignores the `index.html` file and itself to prevent recursion
 *   issues. 
 * - SVG icons are used for visual representation of different file types and
 *   directories.
 */

declare(strict_types=1);

// Record the start time of the script for performance measurement
define('TIME_START', microtime(TRUE));

// Define the version of the script
const VERSION = 'v1.0.0-rc.30';

// Determine if the script is running in a console (CLI) environment
const IS_RUNNING_IN_CONSOLE = PHP_SAPI === 'cli';

// Start output buffering to capture generated HTML content
ob_start();

// Define translations for supported languages: English, Norwegian, Filipino, Spanish, and French
$translations = [
  'en' => [
    'directory_listing' => 'Directory Listing',
    'name' => 'Name',
    'last_modified' => 'Last Modified',
    'size' => 'Size',
    'parent_directory' => 'Parent Directory',
    'loading_message' => 'Generating directory listing... ',
    'done_message' => 'Done! Finished in ',
    'generated_on' => 'was generated on',
  ],
  'nb' => [
    'directory_listing' => 'Katalog',
    'name' => 'Navn',
    'last_modified' => 'Sist endret',
    'size' => 'Størrelse',
    'parent_directory' => 'Hovedmappe',
    'loading_message' => 'Genererer katalog... ',
    'done_message' => 'Ferdig! Ferdig på ',
    'generated_on' => 'ble generert den',
  ],
  'fil' => [
    'directory_listing' => 'Listahan ng Direktoryo',
    'name' => 'Pangalan',
    'last_modified' => 'Huling Binago',
    'size' => 'Laki',
    'parent_directory' => 'Direktoryo ng Magulang',
    'loading_message' => 'Nagbuo ng listahan ng direktoryo... ',
    'done_message' => 'Tapos! Natapos sa ',
    'generated_on' => 'ay nabuo noong',
  ],
  'es' => [
    'directory_listing' => 'Listado de Directorios',
    'name' => 'Nombre',
    'last_modified' => 'Última Modificación',
    'size' => 'Tamaño',
    'parent_directory' => 'Directorio Principal',
    'loading_message' => 'Generando listado de directorios... ',
    'done_message' => '¡Hecho! Terminado en ',
    'generated_on' => 'fue generado el',
  ],
  'fr' => [
    'directory_listing' => 'Liste des Répertoires',
    'name' => 'Nom',
    'last_modified' => 'Dernière Modification',
    'size' => 'Taille',
    'parent_directory' => 'Répertoire Parent',
    'loading_message' => 'Génération de la liste des répertoires... ',
    'done_message' => 'Terminé! Terminé en ',
    'generated_on' => 'a été généré le',
  ],
];

// Set default language to English
$lang = 'en';

// Check if a language argument is provided via command line or web request
if (IS_RUNNING_IN_CONSOLE) {
  $options = getopt("", ["lang:"]);
  if (isset($options['lang']) && in_array($options['lang'], ['en', 'nb', 'fil', 'es', 'fr'])) {
    $lang = $options['lang'];
  }
} else {
  // For web use, maintain session-based language selection
  session_start();
  if (isset($_GET['lang'])) {
    $lang = $_GET['lang'];
    $_SESSION['lang'] = $lang;
  } elseif (isset($_SESSION['lang'])) {
    $lang = $_SESSION['lang'];
  }
}

// Select the appropriate translations based on the selected language
$trans = $translations[$lang] ?? $translations['en'];

// Get the name of the current script file to exclude it from directory listings
$scriptFileName = basename(__FILE__);

// If running in the console, output a message indicating the start of directory listing generation
if (IS_RUNNING_IN_CONSOLE) {
  file_put_contents('php://stdout', $trans['loading_message']);
}

/**
 * Generates a directory listing for the given directory path.
 *
 * @param string $directoryPath Path to the directory to list.
 * @param string $relativePathToRoot Relative path from the current directory to the root directory.
 * @param string $scriptFileName Name of the script file to exclude from the listing.
 */
function generateDirectoryListing(string $directoryPath, string $relativePathToRoot, string $scriptFileName): void
{
  global $trans, $lang;

  // Get directory entries, excluding hidden files, index.html, and the script itself
  $directoryEntries = array_filter(glob($directoryPath . DIRECTORY_SEPARATOR . '*'), function ($filePath) use ($scriptFileName) {
    return !isHiddenFile($filePath) && basename($filePath) !== 'index.html' && basename($filePath) !== $scriptFileName;
  });

  // Sort directory entries, directories first, then files
  usort($directoryEntries, function (string $entryA, string $entryB): int {
    return compareDirectoryEntries($entryA, $entryB);
  });

  // Generate the header for the directory listing table
  echo '<div class="file-list__header">
             <div class="file-list__column-header">' . $trans['name'] . '</div>
             <div class="file-list__column-header">' . $trans['last_modified'] . '</div>
             <div class="file-list__column-header">' . $trans['size'] . '</div>
           </div>';

  // Generate a grid item for each entry in the directory
  foreach ($directoryEntries as $entry) {
    generateGridItem($entry);

    // If the entry is a directory, generate a subdirectory index
    if (is_dir($entry)) {
      generateSubdirectoryIndex($entry, $relativePathToRoot, $scriptFileName);
    }
  }
}

/**
 * Checks if a file is hidden (starts with a dot).
 *
 * @param string $filePath Path to the file.
 * @return bool Returns true if the file is hidden, false otherwise.
 */
function isHiddenFile(string $filePath): bool
{
  return substr(basename($filePath), 0, 1) === '.';
}

/**
 * Compares two directory entries for sorting.
 *
 * @param string $entryA First directory entry.
 * @param string $entryB Second directory entry.
 * @return int Comparison result, used for sorting.
 */
function compareDirectoryEntries(string $entryA, string $entryB): int
{
  if (is_dir($entryA) && !is_dir($entryB)) {
    return -1;
  } elseif (!is_dir($entryA) && is_dir($entryB)) {
    return 1;
  } elseif (is_file($entryA) && is_file($entryB)) {
    return strcasecmp($entryA, $entryB);
  }
  return strcasecmp($entryA, $entryB);
}

/**
 * Calculates the total size of a directory recursively.
 *
 * @param string $directory Path to the directory.
 * @return int Total size of the directory in bytes.
 */
function calculateDirectorySize(string $directory): int
{
  $size = 0;

  // Iterate through all files and directories within the directory to sum up the size
  foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory, FilesystemIterator::SKIP_DOTS)) as $file) {
    $size += $file->getSize();
  }

  return $size;
}

/**
 * Generates a grid item for the directory listing.
 *
 * @param string $filePath Path to the file or directory.
 */
function generateGridItem(string $filePath): void
{
  global $trans;

  // Gather file or directory details
  $fileName = basename($filePath) . (is_dir($filePath) ? '/' : '');
  $fileExtension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
  $fileSize = is_dir($filePath) ? formatFileSize(calculateDirectorySize($filePath)) : formatFileSize(filesize($filePath));
  $lastModified = date('Y-m-d H:i', filemtime($filePath));
  $lastModifiedISO = date('c', filemtime($filePath));
  $iconSVG = determineIconSVG($fileExtension, is_dir($filePath));

  // Output the grid item HTML
  echo buildGridItemHTML($iconSVG, $fileName, $lastModifiedISO, $lastModified, $fileSize);
}

/**
 * Determines the appropriate SVG icon based on the file extension or directory status.
 *
 * @param string $fileExtension File extension of the file.
 * @param bool $isDirectory Whether the entry is a directory.
 * @return string SVG icon as a string.
 */
function determineIconSVG(string $fileExtension, bool $isDirectory): string
{
  if ($isDirectory) {
    return getFolderSVG();
  }

  // Return specific icons based on file extension
  switch ($fileExtension) {
    case 'jpg':
    case 'jpeg':
    case 'png':
    case 'gif':
    case 'bmp':
    case 'svg':
      return getImageSVG();
    case 'mp4':
    case 'mkv':
    case 'avi':
    case 'mov':
    case 'wmv':
    case 'flv':
    case 'webm':
      return getVideoSVG();
    case 'mp3':
    case 'wav':
    case 'ogg':
    case 'flac':
    case 'aac':
      return getAudioSVG();
    case 'pdf':
      return getPDFSVG();
    case 'doc':
    case 'docx':
      return getWordSVG();
    case 'xls':
    case 'xlsx':
      return getExcelSVG();
    case 'ppt':
    case 'pptx':
      return getPowerPointSVG();
    case 'txt':
    case 'md':
    case 'log':
      return getTextSVG();
    case 'html':
    case 'htm':
    case 'css':
    case 'js':
      return getCodeSVG();
    case 'zip':
    case 'rar':
    case '7z':
    case 'tar':
    case 'gz':
      return getArchiveSVG();
    default:
      return getFileSVG();
  }
}

/**
 * Builds the HTML for a grid item in the directory listing.
 *
 * @param string $iconSVG SVG icon for the file type.
 * @param string $fileName Name of the file or directory.
 * @param string $lastModifiedISO ISO 8601 formatted last modified date.
 * @param string $lastModified Human-readable last modified date.
 * @param string $fileSize Formatted file size.
 * @return string HTML for the grid item.
 */
function buildGridItemHTML(string $iconSVG, string $fileName, string $lastModifiedISO, string $lastModified, string $fileSize): string
{
  $escapedFileName = htmlspecialchars($fileName, ENT_QUOTES, 'UTF-8');

  return <<<HTML
 <div class="file-list__row">
     <div class="file-list__cell">$iconSVG <a class="file-list__link" href="$escapedFileName">$escapedFileName</a></div>
     <div class="file-list__cell"><time datetime="$lastModifiedISO">$lastModified</time></div>
     <div class="file-list__cell">$fileSize</div>
 </div>
 HTML;
}

/**
 * Formats a file size into a human-readable string.
 *
 * @param int $sizeInBytes Size in bytes.
 * @return string Formatted size string.
 */
function formatFileSize(int $sizeInBytes): string
{
  if ($sizeInBytes < 1024) {
    return $sizeInBytes . ' B';
  } elseif ($sizeInBytes < 1048576) {
    return round($sizeInBytes / 1024, 2) . ' kB';
  } elseif ($sizeInBytes < 1073741824) {
    return round($sizeInBytes / 1048576, 2) . ' MB';
  } else {
    return round($sizeInBytes / 1073741824, 2) . ' GB';
  }
}

/**
 * Generates an index.html for a subdirectory and processes its contents.
 *
 * @param string $subdirectoryPath Path to the subdirectory.
 * @param string $relativePathToRoot Relative path to the root directory.
 * @param string $scriptFileName Name of the script file to exclude.
 */
function generateSubdirectoryIndex(string $subdirectoryPath, string $relativePathToRoot, string $scriptFileName): void
{
  global $trans, $lang;

  $originalDirectory = getcwd();
  chdir($subdirectoryPath);
  ob_start();

  // Calculate relative path from subdirectory to root
  $relativePathFromSubdirectoryToRoot = str_repeat('../', substr_count(getcwd(), DIRECTORY_SEPARATOR) - substr_count($relativePathToRoot, DIRECTORY_SEPARATOR));
  generateDirectoryListing(getcwd(), $relativePathToRoot, $scriptFileName);

  $content = ob_get_clean();
  $shouldShowParentLink = ($subdirectoryPath !== $relativePathToRoot);

  // Build and save the index.html file
  $html = buildHTMLDocument($content, $relativePathFromSubdirectoryToRoot, $shouldShowParentLink, $lang, $subdirectoryPath);
  file_put_contents('index.html', $html);
  foreach (glob('*', GLOB_ONLYDIR) as $subdirectory) {
    generateSubdirectoryIndex($subdirectory, $relativePathToRoot, $scriptFileName);
  }

  chdir($originalDirectory);
}

/**
 * Builds the complete HTML document for the directory listing.
 *
 * @param string $content HTML content for the directory listing.
 * @param string $relativePathFromSubdirectoryToRoot Relative path from the current subdirectory to the root.
 * @param bool $shouldShowParentLink Whether to show the "Parent Directory" link.
 * @param string $lang Language code for the document.
 * @param string|null $subdirectoryPath Optional subdirectory path for display in the generated message.
 * @return string Complete HTML document.
 */
function buildHTMLDocument(string $content, string $relativePathFromSubdirectoryToRoot, bool $shouldShowParentLink, string $lang, ?string $subdirectoryPath = null): string
{
  global $trans;

  // Add a link to the parent directory if applicable
  $parentLinkHTML = '';
  if ($shouldShowParentLink) {
    $parentLinkHTML = '<div class="file-list__row"><div class="file-list__cell">' .
      getUpwardArrowSVG() .
      '<a class="file-list__link" href="' . htmlspecialchars($relativePathFromSubdirectoryToRoot, ENT_QUOTES, 'UTF-8') . '">' . $trans['parent_directory'] . '</a></div>' .
      '<div class="file-list__cell">&nbsp;</div>' .
      '<div class="file-list__cell">-</div></div>';
  }

  // Prepare the generated message at the bottom of the HTML
  $generatedTime = date('Y-m-d H:i:s');
  $generatedMessage = $subdirectoryPath
    ? basename($subdirectoryPath) . "/index.html " . $trans['generated_on'] . " $generatedTime"
    : "index.html " . $trans['generated_on'] . " $generatedTime";

  return <<<HTML
 <!DOCTYPE html>
 <html lang="{$lang}">
 
 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <meta name="description" content="{$trans['directory_listing']}">
     <meta name="robots" content="noindex">
     <title>{$trans['directory_listing']}</title>
     <link href="https://fonts.googleapis.com/css2?family=Literata:ital,opsz,wght@0,7..72,200..900;1,7..72,200..900&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Source+Code+Pro:ital,wght@0,200..900;1,200..900&display=swap" rel="stylesheet">
     <style>
         html {
             font-size: 62.5%;
         }
         body {
             font-family: 'Literata', serif;
             font-size: 1.5rem;
             margin: 0;
             padding: 0;
             line-height: 1.6;
             color: #333;
             background-color: #f9f9f9;
         }
         .header {
             padding: 2rem;
             background-color: #f4f4f4;
             text-align: center;
             border-bottom: 1px solid #ddd;
         }
         .header__title {
             font-size: clamp(3.2rem, 5vw + 2rem, 5.052rem);
             margin: 0;
             font-family: 'Montserrat', sans-serif;
         }
         .content {
             padding: 2rem;
         }
         .file-list {
             display: grid;
             grid-template-columns: 1fr 1fr 1fr;
             gap: 1rem;
             margin-top: 2rem;
             border-collapse: collapse;
         }
         .file-list__header, .file-list__row {
             display: contents;
         }
         .file-list__column-header, .file-list__cell {
             padding: 1rem;
             border-bottom: 1px solid #ddd;
         }
         .file-list__column-header {
             font-weight: bold;
             background-color: #f2f2f2;
         }
         .file-list__row:nth-child(even) .file-list__cell {
             background-color: #f9f9f9;
         }
         .file-list__row:nth-child(odd) .file-list__cell {
             background-color: #ffffff;
         }
         .icon {
             margin-right: 1rem;
             vertical-align: middle;
         }
         .file-list__link {
             text-decoration: none;
             color: #007bff;
         }
         .file-list__link:hover {
             text-decoration: underline;
         }
         .footer {
             text-align: right;
             margin-top: 2rem;
             font-size: 1.2rem;
             color: #777;
         }
         @media (max-width: 768px) {
             .file-list {
                 grid-template-columns: 1fr 1fr;
                 gap: 1rem;
             }
             .file-list__column-header {
                 display: none; /* Hide headers on mobile for a cleaner look */
             }
             .file-list__cell {
                 padding: 0.75rem;
                 font-size: 1.4rem;
             }
             .file-list__row {
                 display: flex;
                 flex-direction: column;
                 border-bottom: 1px solid #ddd;
             }
             .file-list__cell {
                 display: flex;
                 justify-content: space-between;
             }
             .file-list__cell:first-child {
                 flex-direction: row;
                 justify-content: flex-start;
                 align-items: center;
             }
             .file-list__cell:last-child {
                 margin-top: 0.5rem;
             }
             .footer {
                 text-align: center;
             }
         }
 
         @media (max-width: 480px) {
             .file-list {
                 grid-template-columns: 1fr;
             }
             .file-list__cell {
                 padding: 0.5rem;
                 font-size: 1.2rem;
             }
             .header__title {
                 font-size: 4rem; /* Smaller title for very small screens */
             }
         }
     </style>
 </head>
 
 <body class="page">
     <header class="header">
         <h1 class="header__title">{$trans['directory_listing']}</h1>
     </header>
     <main class="content">
         <div class="file-list">
             $parentLinkHTML
             $content
         </div>
         <div class="footer">$generatedMessage</div>
     </main>
 </body>
 
 </html>
 HTML;
}

/**
 * Returns the SVG for a folder icon.
 */
function getFolderSVG(): string
{
  return <<<SVG
 <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="#ff9800" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-folder"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h6l2 3h8a2 2 0 0 1 2 2z"/></svg>
 SVG;
}

/**
 * Returns the SVG for a generic file icon.
 */
function getFileSVG(): string
{
  return <<<SVG
 <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="#9e9e9e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-file"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/></svg>
 SVG;
}

/**
 * Returns the SVG for an image file icon.
 */
function getImageSVG(): string
{
  return <<<SVG
 <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="#4caf50" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-image"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><path d="M8.5 12.5l2 2 3.5-3.5"/><path d="M14 14l2.5 2.5"/><path d="M9 9h.01"/></svg>
 SVG;
}

/**
 * Returns the SVG for a video file icon.
 */
function getVideoSVG(): string
{
  return <<<SVG
 <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="#f44336" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-video"><rect x="2" y="2" width="20" height="14" rx="2.18" ry="2.18"/><path d="M7 22V2"/><path d="M17 22V2"/><path d="M2 14h20"/></svg>
 SVG;
}

/**
 * Returns the SVG for an audio file icon.
 */
function getAudioSVG(): string
{
  return <<<SVG
 <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="#9c27b0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-audio"><path d="M9 18V5l12-2v13"/><path d="M9 18v2a4 4 0 0 0 8 0v-2"/><path d="M9 9l12-2"/></svg>
 SVG;
}

/**
 * Returns the SVG for a PDF file icon.
 */
function getPDFSVG(): string
{
  return <<<SVG
 <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="#e53935" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-pdf"><rect x="2" y="2" width="20" height="20" rx="2" ry="2"/><path d="M6 12h12"/><path d="M6 16h12"/><path d="M6 8h12"/></svg>
 SVG;
}

/**
 * Returns the SVG for a Word document icon.
 */
function getWordSVG(): string
{
  return <<<SVG
 <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="#3f51b5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-word"><path d="M4 22V2h10l6 6v14H4z"/><path d="M14 2v6h6"/><path d="M10 9v4"/><path d="M14 9v4"/></svg>
 SVG;
}

/**
 * Returns the SVG for an Excel document icon.
 */
function getExcelSVG(): string
{
  return <<<SVG
 <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="#4caf50" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-excel"><path d="M4 22V2h10l6 6v14H4z"/><path d="M14 2v6h6"/><path d="M10 9v4"/><path d="M14 9v4"/></svg>
 SVG;
}

/**
 * Returns the SVG for a PowerPoint document icon.
 */
function getPowerPointSVG(): string
{
  return <<<SVG
 <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="#ff5722" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-powerpoint"><path d="M2 12a10 10 0 1 0 20 0 10 10 0 0 0-20 0z"/><path d="M12 2v20"/><path d="M12 12l7-7"/><path d="M12 12l-7-7"/></svg>
 SVG;
}

/**
 * Returns the SVG for a text file icon.
 */
function getTextSVG(): string
{
  return <<<SVG
 <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="#607d8b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-text"><rect x="2" y="2" width="20" height="20" rx="2" ry="2"/><path d="M6 8h12"/><path d="M6 12h12"/><path d="M6 16h12"/></svg>
 SVG;
}

/**
 * Returns the SVG for a code file icon (HTML, CSS, JS).
 */
function getCodeSVG(): string
{
  return <<<SVG
 <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="#e34c26" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-code"><path d="M16 18l6-6-6-6"/><path d="M8 6L2 12l6 6"/></svg>
 SVG;
}

/**
 * Returns the SVG for an archive file icon.
 */
function getArchiveSVG(): string
{
  return <<<SVG
 <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="#795548" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-archive"><rect x="2" y="2" width="20" height="16" rx="2" ry="2"/><path d="M2 10h20"/><path d="M12 14v4"/></svg>
 SVG;
}

/**
 * Returns the SVG for the upward-pointing arrow icon (for Hovedmappe).
 */
function getUpwardArrowSVG(): string
{
  return <<<SVG
 <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="#ff9800" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-upward-arrow"><path d="M12 19V6"/><path d="M5 12l7-7 7 7"/></svg>
 SVG;
}

// Initialize the script by generating the directory listing for the root directory
$rootDirectory = getcwd();
generateDirectoryListing($rootDirectory, $rootDirectory, $scriptFileName);

// Output the final index.html file for the root directory
file_put_contents('index.html', buildHTMLDocument(ob_get_clean(), '', FALSE, $lang));

// If running in the console, output the time taken to complete the operation
if (IS_RUNNING_IN_CONSOLE) {
  $executionTimeMs = (microtime(TRUE) - TIME_START) * 1000;
  file_put_contents('php://stdout', $trans['done_message'] . number_format($executionTimeMs, 2) . ' ms.' . PHP_EOL);
}
