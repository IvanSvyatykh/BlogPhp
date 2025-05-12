import { JetView } from "webix-jet";
import "webix/webix.js";
import MainToolBar from "./maintoolbar";
import { objectToQueryString, updateToolbarButtons } from "../utils";

export default class UserView extends JetView {
    isEditing = false;

    config() {
        return {
            cols: [
                {
                    $subview: MainToolBar
                },

                {
                    margin: 10,
                    padding: { top: 10, right: 10, left: 10, bottom: 10 },
                    gravity: 3,
                    cols: [
                        {
                            rows: [
                                {
                                    view: "datatable",
                                    id: "userDataTable",
                                    css: "user_data_table",
                                    select: true,
                                    columns: [
                                        
                                        { id: "login", header: "Логин", readonly: true, fillspace: true },

                                        { id: "name", header: "Имя", readonly: true, fillspace: true },

                                        { id: "email", header: "Почта", readonly: true, fillspace: true },

                                        { id: "active", header: "Активен", fillspace: true }

                                    ],
                                    scroll: false,
                                    on: 
                                    { 
                                        onItemClick: (id) => this.editItem(id),                                
                                    }                                   
                                }
                            ]
                        },

                        {
                            view: "form",
                            id: "editForm",
                            width: 300,
                            minWidth: 280,
                            maxWidth: 305,

                            gravity: 1,
                            hidden: true,
                            margin: 10,
                            padding: { top: 10, right: 10, left: 10, bottom: 10 },
                            css: "user_edit_form",
                            elements: [
                                { view: "text", name: "login" },

                                { view: "text", name: "name" },

                                { view: "text", name: "email" },

                                { template: "{common.checkbox()}" },

                                {

                                    cols: [
                                        { view: "button", id: "saveButton", css:"main_button", value: "Сохранить", autowidth: true, click: () => this.saveItem() },

                                        {},

                                        { view: "button", id: "deleteButton", css: "delete_button", value: "Удалить", autowidth: true, click: () => this.deleteItem() }
                                    ]
                                }
                            ]
                        },

                        { 
                            width: 20
                        }
                    ]
                }
            ]
        };
    }

    async loadUsers() {
        try {
            const response = await webix.ajax().get(`${BASE_URL}/user`);
            $$("userDataTable").clearAll();
            $$("userDataTable").parse(response.json().users);
        } catch (error) {
            this.showError(error);
        }
    }

    editItem(id) {
        const editForm = $$("editForm");
        this.isEditing = true;
        const item = $$("userDataTable").getItem(id);

        editForm.elements.login.define("readonly", this.isEditing);
        editForm.elements.login.refresh();
        editForm.setValues(item);
        editForm.show();
    }

    switchActive() {
        webix.ajax().patch(`${BASE_URL}/user?login=${item.login}`).then(() => {
            webix.message("Изменено");
            this.loadUsers();
            $$("editForm").hide();
        }).catch((error) => {
            webix.message({ type: "error", text: error.response });
        })
    }
    
    async init() {
        await this.loadUsers();
        this.loadGroups();
    }

    ready() {
        updateToolbarButtons($$("userButton"));
    }
}