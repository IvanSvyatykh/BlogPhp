import { JetView } from "webix-jet";
import MainToolBar from "./maintoolbar";

export default class MainLayout extends JetView {
    config() {
        return {
            css: "main_container",
            cols: [
                {
                    $subview: MainToolBar
                }
            ]
        };
    }
}