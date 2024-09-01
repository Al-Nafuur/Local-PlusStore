/*
* Local PlusStore API for PlusCarts
* Copyright 2024 Wolfgang Stubig
* Version: v1.1.0
*
* missing features (some might be added, but most don't make sense in a local environment):
*  - Search function
*  - "Popular ROMs"
*  - "Recently added ROMs"
*  - "My Favourite ROMs"
*  - "My Recently Played ROMs"
*  - Text file reading
*  - ZIP/tar file unpacking
*  - High Score Club list
*  - PlusCart chat
*  - List of users online
*
* WiFi update feature is untested !
*/

SSJSKey = 'wa4e76yhefy54t4a'


function plusCartFileType(filename){
    if(filename.endsWith('.txt'))
        return "1 ";
    return "2 ";
}

var responseBody = '';
var path = req.arguments.u === '1' ? 'firmware.bin' : req.arguments.p;
res.getFile('/' + path, function(file) {
    if (file.isFile) {
        res.renderFileContents(file);
    } else {
        if (file.error) {
            responseBody += '0 000000 error\n';
        } else if (file.isDirectory) {
            if(file.origpath != '/' && file.origpath != '/Setup')
                responseBody += '0 000000 ..\n';
            file.getDirContents(function(results) {
                var dirs = [];
                var files = [];
                results.forEach((element) => {
                    if (element.isDirectory){
                        dirs.push(element);
                    }else if (element.isFile){
                        files.push(element);
                    }
                });
                dirs.forEach((dir) => {
                    responseBody += '1 000000 ' + dir.name + '\n';
                });
                files.forEach((file_in_dir) => {
                    if(file_in_dir.name == "firmware.bin" && file.origpath == '/'){
                        responseBody = '6 ' + file_in_dir.size.toString().padStart(6, '0') + ' ** WiFi Firmware Update **\n' + responseBody;
                    } else {
                        responseBody += plusCartFileType(file_in_dir.name) + file_in_dir.size.toString().padStart(6, '0') + ' ' + file_in_dir.name + '\n';
                    }
                });
            });
        } else {
             responseBody += '0 000000 file/dir not found\n';
        }
        res.write('00\n' + responseBody);
        res.end();
    }
})
