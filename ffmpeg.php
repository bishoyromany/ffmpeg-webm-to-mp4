<?php 
/**
 * Important Notes Before Start 
 * 1 - download and install composer after install xampp 
 * 2 - run this command inside c:\xampp\htodcs\the folder that you wanna create the converter in 
 * composer require php-ffmpeg/php-ffmpeg 
 * 3 - install the ffmpeg from this website 
 * https://ffmpeg.zeranoe.com/builds/
 * and update the links down :) 
 */

/**
 * load FFMpeg Composer Files
 */
require 'vendor/autoload.php';

/**
 * require FFMPEG Classes
 */
use FFMpeg\FFMpeg;
use FFMpeg\Format\Video\X264;

class convertToMp4{
    private $videoUrl;
    private $videoPath;

    /**
     * a function to call once te class is called
     */
    public function __construct(){

    }

    /**
     * @param video the input video location
     * @param export the exported video location
     */
    public function convert($video , $export){
        /**
         * @param ffmpeg.binaries the location of ffmpeg on windows
         * @param ffprobe.binaries the location of ffprobe on windows
         */
        $ffmpeg = FFMpeg::create([
            'ffmpeg.binaries'  => 'C:\ffmpeg\ffmpeg.exe',
            'ffprobe.binaries' => 'C:\ffmpeg\ffprobe.exe',
            'timeout'          => 3600, // The timeout for the underlying process
            'ffmpeg.threads'   => 4,   // The number of threads that FFMpeg should use
        ]);

        /**
         * Get Video Data
         */
        $videoData = $ffmpeg->open($video);

        // Configure the new mp4 format
        $mp4Format = new X264();

        // Fix for error "Encoding failed : Can't save to X264"    
        $mp4Format->setAudioCodec("libmp3lame");
        
        // save the converted video 
        $videoData->save($mp4Format,$export);

        // save the video public location to a variable in the class, to use it later for downloading
        $ll = explode('/' , $export);
        $ll = $ll[count($ll) - 1];
        // if you have any specific folder right it beteween '/' and $ll
        $this->videoUrl = 'http://'.$_SERVER['HTTP_HOST'].'/'.$ll;

        $this->videoPath = $export;

        return "saved successfully";
    }

    /**
     * download the video for public
     */
    public function downloadUrl(){
        return $this->videoUrl;
    }

    /**
     * download the video for server side
     */
    public function downloadPath(){
        return $this->videoPath;
    }
}

/**
 * webm video and the location where the converted video should be saved
 */
$exportFileName = 'test.mp4';
$inputVideoLocation = __DIR__.'/test.webm';
$exportVideoLocation = __DIR__.'/'.$exportFileName;

$convertor = new convertToMp4();
$convertor->convert($inputVideoLocation , $exportVideoLocation);

// set download video in mp4 header

$downloadPublicUrl = $convertor->downloadUrl();

header("Cache-Control: public");
header("Content-Disposition: attachment; filename=$exportFileName");
header("Content-Type: video/mp4");
header("Content-Transfer-Encoding: binary");
header("Content-Description: File Transfer");

readfile($convertor->downloadPath());

exit;

