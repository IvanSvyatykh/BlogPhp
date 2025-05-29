let jetApp = null;

export function setupAuthRedirect(appInstance) {
	jetApp = appInstance;
}

const TOKEN_KEY = "jwt_token";

export function getToken() {
    return localStorage.getItem(TOKEN_KEY);
}

export function setToken(token) {
    localStorage.setItem(TOKEN_KEY, token);
}

export function clearToken() {
    localStorage.removeItem(TOKEN_KEY);
}

export function isUnauthorized(responseText) {
    try {
        const json = JSON.parse(responseText);
        return json?.error?.message === "Unauthorized";

    } catch {
        return false;
    }
}

export function handleUnauthorized() {
    clearToken();
    webix.delay(() => webix.redirect("/login"));
}

export function setupAuthInterceptor() {
    webix.attachEvent("onBeforeAjax", function (mode, url, data, request, headers) {
        const token = getToken();
        console.log("ajax")
        if (token) {
            headers["Authorization"] = `Bearer ${token}`;
            headers["Content-Type"] = "application/json";
        }
    });

    webix.attachEvent("onAfterAjax", function (mode, url, data, request, response) {
        const body = response.responseText;
        console.log("after ajax");
        if (isUnauthorized(body)) {
            handleUnauthorized();
            return false;
        }
    });
}
export async function checkAuthResponse(response) {
    if (response?.error?.message === "Unauthorized" || response === null) {
        clearToken();
        webix.delay(() => jetApp.show("/login"));
    }
}

