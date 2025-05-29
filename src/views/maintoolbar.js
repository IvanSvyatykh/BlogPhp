import { JetView } from "webix-jet";
import { clearToken } from "../auth";

export default class MainToolBar extends JetView {
    config() {
        const apiInstnc = this.app;
        return {
            view: "toolbar",
            id: "mainToolBar",
            css: "toolbar",
            paddingX: 20,
            paddingY: 10,

            rows: [
                {
                    view: "button",
                    template: `<img src = './src/styles/bigN.svg', class='bigN_toolbar'>`,
                    width: 100,
                    height: 100,
                    click: () => this.app.show("/main")
                },

                {
                    id: "toolbarButtons",
                    rows: [
                        {
                            view: "button",
                            id: "articleButton",
                            autowidth: true,
                            css: "main_button",
                            value: "Статьи",
                            click: () => apiInstnc.show("/article")
                        },
                
                        {
                            view: "button",
                            id: "userButton",
                            autowidth: true,
                            css: "main_button",
                            value: "Пользователи",
                            click: () => apiInstnc.show("/users")
                        },

                        {
                            view: "button",
                            id: "infoButton",
                            autowidth: true,
                            css: "main_button",
                            value: "Информация",
                            click: () => apiInstnc.show("/info")
                        }
                        
                    ],
                    css: "main_toolbar_buttons",
                    margin: 10
                },
                
                {
                    view: "button",
                    template: `<img src = './src/styles/logout.svg' class='logout_button'>`,
                    width: 50,
                    click: () => this.logout()
                }
            ]
        };
    }

    logout() {
        clearToken();
        this.app.show("/login");
    }
}