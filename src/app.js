import "webix/webix.js";
import { JetApp, JetView } from "webix-jet";
import UserView from "./views/user.js";
import MainLayout from "./views/main.js";
import MainToolBar from "./views/maintoolbar.js";
import Article from "./views/article.js";

window.BASE_URL = import.meta.env.VITE_BASE_URL;

class MyApp extends JetApp {
    constructor(config) {
        super({
            id: "myapp",
            start: "/main",
            views: { 
                users: UserView, 
                main: MainLayout, 
                toolbar: MainToolBar,
                article: Article
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
    app.render();
    window.app = app;
});

export default MyApp;