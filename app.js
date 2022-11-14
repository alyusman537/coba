document.getElementById('inputfile')
    .addEventListener('change', function () {

        var fr = new FileReader();
        fr.onload = function () {
            document.getElementById('output')
                .textContent = fr.result;
        }

        fr.readAsText(this.files[0]);
    });
function cprint() {
   var pre = document.getElementById('output');
    pre.contentWindow.print();
};
function getOS() {
    var navi = window.navigator,
        userAgent = navi.userAgent,
        platform = navi.platform,
        macosPlatforms = ['Macintosh', 'MacIntel', 'MacPPC', 'Mac68K'],
        windowsPlatforms = ['Win32', 'Win64', 'Windows', 'WinCE'],
        iosPlatforms = ['iPhone', 'iPad', 'iPod'],
        os = null;
    if (macosPlatforms.indexOf(platform) !== -1) {
        os = 'Mac OS';
    } else if (iosPlatforms.indexOf(platform) !== -1) {
        os = 'iOS';
    } else if (windowsPlatforms.indexOf(platform) !== -1) {
        os = 'Windows';
    } else if ((/Android/).test(userAgent)) {
        os = 'Android';
    } else if (!os && (/Linux/).test(platform)) {
        os = 'Linux';
    }
    return os;
};
function setOs() {
    if ( getOS() == 'Android' ) {
        // perintah jika OS Android
       } else if ( getOS() == 'Windows' ) {
        // perintah jika OS Android
        console.log('ini os Windows', getOS());
       } else {
        console.log('ini os linux', getOS());
       }
}
function WriteToFile(passForm) {
 
    var fso = CreateObject("Scripting.FileSystemObject");
    const os = getOS();
    var dir = null;
    if( os == 'Windows'){
        dir = 'C:/'
    } else if(os == 'Linux'){
        dir = '~/Documents/'
    }
    var s   = fso.CreateTextFile(dir+"filename.txt", True);
 
    var firstName = document.getElementById('FirstName');
    var lastName  = document.getElementById('lastName');
 
    s.writeline("First Name :" + firstName);
    s.writeline("Last Name :" + lastName);
 
    s.writeline("-----------------------------");
    s.Close();
 }
