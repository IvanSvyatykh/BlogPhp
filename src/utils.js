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
