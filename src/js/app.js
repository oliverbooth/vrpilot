const semver = require("semver");
const AppVersion = semver(semver.clean("<%PKG.VERSION%>"));

let updateInterval;

let API = {
    get: (path, cb) => {
        $.ajax({
            url: "/api/" + path,
            type: "GET",
            success: (response) => {
                if (response.status === 200) {
                    cb(response.response);
                }
            }
        });
    }
};

let checkForUpdates = () => {
    $.ajax({
        url: "https://api.github.com/repos/oliverbooth/vrpilot/releases/latest",
        type: "GET",
        success: (response) => {
            let responseVersion = response.tag_name;
            if ((responseVersion.match(/\./g || []).length) === 1) {
                responseVersion += ".0";
            }

            let elementHtml = "";
            let latestVersion = semver(semver.clean(responseVersion));
            let compare = (semver.compare(latestVersion, AppVersion));

            if (compare < 1) {
                elementHtml = "<i class=\"fas fa-fw fa-check-circle text-success\"></i> Up to date";
            } else {
                elementHtml = "<i class=\"fas fa-fw fa-download text-info\"></i> Update available";
            }

            $("#app-update-span").html("<strong>" + elementHtml + "</strong>");
        },
        error: (response) => {
            let elementHtml = "<i class=\"fas fa-fw fa-times-circle text-danger\"></i> Error checking for updates";
            $("#app-update-span").html("<strong>" + elementHtml + "</strong>");
        }
    });
};

let updateIntervalImpl = () => {
    $("#dashboard-watch-preview").attr("src", "/");
    $("#dashboard-watch-preview").attr("src", "/watch?" + (new Date()).getTime());

    API.get("/mode", (data) => {
        let klass = "", icon = "", text = "";
        switch (data.mode) {
            case 0:
                klass = "success";
                icon = "tv";
                text = "Regular Programming";
                break;
            case 1:
                klass = "danger";
                icon = "video";
                text = "Live Now";
                break;
            case 2:
                klass = "warning";
                icon = "exclamation-triangle";
                text = "Technical Difficulties";
                break;
        }
        $("#dashboard-mode-display").removeClass().addClass("badge badge-" + klass).html(
            "<i class=\"fas fa-" + icon + "\"></i> " + text
        );
    });
};

$(() => {
    updateIntervalImpl();
    
    API.get("/version", (data) => {
        $("#app-version-span").text(data.version);
        checkForUpdates();
    });

    API.get("/spf", (data) => {
        updateInterval = setInterval(updateIntervalImpl, data.spf * 500);
    });
});