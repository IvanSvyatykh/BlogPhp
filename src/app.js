import "webix/webix.js";
import { setupAuthInterceptor, setupAuthRedirect } from "./auth.js";
import { JetApp, JetView } from "webix-jet";
import UserView from "./views/user.js";
import MainLayout from "./views/main.js";
import MainToolBar from "./views/maintoolbar.js";
import Article from "./views/article.js";
import Login from "./views/login.js"
import Info from "./views/info.js"

window.BASE_URL = import.meta.env.VITE_BASE_URL;

class MyApp extends JetApp {
    constructor(config) {
        super({
            id: "myapp",
            start: "/login",
            views: {
                users: UserView,
                main: MainLayout,
                toolbar: MainToolBar,
                article: Article,
                login: Login,
                info: Info
            },
            ...config
        });

        this.attachEvent("app:error:server", (error) => {
            this.showServerError(error);
        });
    }
}



document.addEventListener("DOMContentLoaded", () => {
    const app = new MyApp();
    setupAuthRedirect(app);
    setupAuthInterceptor();
    app.render();

    window.app = app;
});

export default MyApp;