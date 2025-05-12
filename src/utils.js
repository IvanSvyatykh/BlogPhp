export function objectToQueryString(params) {
    return Object.keys(params)
        .map(key => encodeURIComponent(key) + "=" + encodeURIComponent(params[key]))
        .join("&");
}

export function setTableColumns(table, columns) {
    $$(table).define("columns", columns);
    $$(table).refreshColumns();
}

export function updateToolbarButtons(activeBtn) {
    
    const buttons = $$("toolbarButtons").getChildViews();
    buttons.forEach(btn => {
        webix.html.removeCss(btn.$view, "selected")
    });
    webix.html.addCss(activeBtn.$view, "selected");
}

export async function loadDevice() {
    try {
        const response = await webix.ajax().get(`${BASE_URL}/device`);
        const deviceData = response.json();
        localStorage.setItem("selectedDevice", JSON.stringify(deviceData));
        webix.message("Устройство успешно загружено");
    } catch (error) {
        webix.message( {type: "error", message: error.response} );
    }
}

