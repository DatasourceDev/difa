function qzDonePrinting() {
    // Alert error, if any
    if (qz.getException()) {
        alert('Error printing:\n\n\t' + qz.getException().getLocalizedMessage());
        qz.clearException();
        return;
    }
    // Alert success message
    console.log('printing');
}

function qzReady() {
    if (!qz) {
        window["qz"] = document.getElementById('qz');
    }
    if (qz) {
        try {
            $('#qz-info-version').html(qz.getVersion());
            useDefaultPrinter();
        } catch (err) { // LiveConnect error, display a detailed message
            alert("ERROR:  \nThe applet did not load correctly.  Communication to the " +
                    "applet has failed, likely caused by Java Security Settings.  \n\n" +
                    "CAUSE:  \nJava 7 update 25 and higher block LiveConnect calls " +
                    "once Oracle has marked that version as outdated, which " +
                    "is likely the cause.  \n\nSOLUTION:  \n  1. Update Java to the latest " +
                    "Java version \n          (or)\n  2. Lower the security " +
                    "settings from the Java Control Panel.");
        }
    }
}

function qzNoConnection() {
    $('#qz-info-printer').html('ไม่พบเครื่องพิมพ์').addClass('text-danger').removeClass('text-primary');
    $('#qz-info-version').html('ไม่พบ QZ Tray ทำงานอยู่').addClass('text-danger').removeClass('text-primary');
}

function isLoaded() {
    if (!qz) {
        alert('Error:\n\n\tPrint plugin is NOT loaded!');
        return false;
    } else {
        try {
            if (!qz.isActive()) {
                alert('Error:\n\n\tPrint plugin is loaded but NOT active!');
                return false;
            }
        } catch (err) {
            alert('Error:\n\n\tPrint plugin is NOT loaded properly!');
            return false;
        }
    }
    return true;
}

function notReady() {
    if (!isLoaded()) {
        return true;
    } else if (!qz.getPrinter()) {
        useDefaultPrinter();
        return true;
    }
    return false;
}

function useDefaultPrinter() {
    if (isLoaded()) {
        qz.findPrinter();
        window['qzDoneFinding'] = function () {
            var printer = qz.getPrinter();
            if (printer !== null) {
                $('#qz-info-printer').html(printer).addClass('text-primary').removeClass('text-danger');
                $('#qz-info-status').html('Ready');
            } else {
                $('#qz-info-printer').html('ไม่พบเครื่องพิมพ์').addClass('text-danger').removeClass('text-primary');
            }
            window['qzDoneFinding'] = null;
        };
    }
}

