import { JetView } from "webix-jet";
import MainToolBar from "./maintoolbar";
import { updateToolbarButtons } from "../utils";

export default class Info extends JetView {
    config() {
        return {
            cols: [
                {
                    $subview: MainToolBar
                },
                {
                    template: `<img src = './src/styles/info.png', class='info_blank'>`,
                }
            ]
        };
    }        

    ready() {
        updateToolbarButtons($$("infoButton"));
    }
}