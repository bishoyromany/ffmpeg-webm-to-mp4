# FFmepg Convert webm videos to mp4 

### To run this file 
1. First Download The File Using, Then extract and move it to htdocs/public_html folder
    ``` git
    git clone https://github.com/bishoyromany/ffmpeg-webm-to-mp4
    ```
2. Install composer then run 
    ```
    composer require php-ffmpeg/php-ffmpeg
    ```
3. if you are using windows download ffmpeg files from here [https://ffmpeg.zeranoe.com/builds/] if you are using linux install it using apt or widget 

4. Open ffmpeg.php file and edit the following 
    
    1. Edit the ffmpeg files path 
        ```php 
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
        ```
    2. Edit the converted video public download url
        ```php 
            // if you have any specific folder right it beteween '/' and $ll
            $this->videoUrl = 'http://'.$_SERVER['HTTP_HOST'].'/'.$ll;
        ```
    
    3. Edit these variables values to the values that match your needs, and add your test videos in the same paths that you add in the bottom variables
        ```php
            /**
             * webm video and the location where the converted video should be saved
            */
            $exportFileName = 'test.mp4'; // export file name
            $inputVideoLocation = __DIR__.'/test.webm'; // import file location/path
            $exportVideoLocation = __DIR__.'/'.$exportFileName; // exported file path
        ```

5. Open the file in the browser or run ``` php ffmpeg ``` but after disabling the download code at the bottom 
    ```php
        header("Cache-Control: public");
        header("Content-Disposition: attachment; filename=$exportFileName");
        header("Content-Type: video/mp4");
        header("Content-Transfer-Encoding: binary");
        header("Content-Description: File Transfer");

        readfile($convertor->downloadPath()); 
    ```


#### Thanks.