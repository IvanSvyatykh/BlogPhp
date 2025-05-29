import {JetView} from "webix-jet";
import "webix/webix.js";
import MainToolBar from "./maintoolbar";
import {objectToQueryString, updateToolbarButtons} from "../utils";
import {checkAuthResponse} from "../auth";

export default class UserView extends JetView {
    config() {
        return {
            cols: [
                {
                    $subview: MainToolBar
                },

                {
                    margin: 10,
                    padding: {top: 10, right: 10, left: 10, bottom: 10},
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

                                        {id: "id", header: "ID", hidden: true},

                                        {id: "login", header: "Логин", readonly: true, fillspace: true},

                                        {id: "role", header: "Роль", readonly: true, fillspace: true},

                                        {
                                            id: "isBanned",
                                            header: "Активен",
                                            template: "{common.checkbox()}",
                                            checkValue: 0,
                                            uncheckValue: 1,
                                            editor: "checkbox",
                                            fillspace: true
                                        }

                                    ],
                                    scroll: false,
                                    on:
                                        {
                                            onItemClick: (id) => this.editItem(id),
                                            onCheck: (rowId, columnId, state) => {
                                                const datatable = this.$$("userDataTable");
                                                const banned = !!state;

                                                const item = datatable.getItem(rowId);
                                                this.switchActive(item.id, banned);
                                            }
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
                            padding: {top: 10, right: 10, left: 10, bottom: 10},
                            css: "user_edit_form",
                            elements: [
                                {
                                    template: `<img src = './src/styles/user.svg', class='user_extra_form'>`,
                                    height: 100,
                                    borderless: true
                                },

                                {
                                    view: "text",
                                    name: "name",
                                    readonly: true,
                                    attributes: {
                                        style: "text-align: center; border : none; font-weight: bold"
                                    }

                                },

                                {
                                    view: "label",
                                    label: "Логин",
                                    align: "center",
                                    css: "auth-label"
                                },
                                {
                                    view: "text",
                                    name: "login",
                                    readonly: true,
                                    css: "auth-text"
                                },

                                {
                                    view: "label",
                                    label: "Создан",
                                    align: "center",
                                    css: "auth-label"
                                },
                                {
                                    view: "text",
                                    name: "createdAt",
                                    readonly: true,
                                    css: "auth-text"
                                },

                                {
                                    view: "label",
                                    label: "Роль",
                                    align: "center",
                                    css: "auth-label"
                                },
                                {
                                    view: "text",
                                    name: "role",
                                    readonly: true,
                                    css: "auth-text"
                                },

                                {
                                    view: "label",
                                    label: "Количество отклоненных постов",
                                    align: "center",
                                    css: "auth-label"
                                },
                                {
                                    view: "label",
                                    label: "Гороскоп",
                                    align: "center",
                                    css: "auth-label"
                                },

                                {
                                    view: "button",
                                    value: "Закрыть",
                                    css: "login_button",
                                    align: "center",
                                    click: function () {
                                        $$("editForm").hide();
                                    }
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
            const raw = await webix.ajax().get(`${BASE_URL}/users/list`);
            const response = await raw.json();
            checkAuthResponse(response);

            if (response) {
                const users = response.map(user => ({
                    ...user,
                    role: user.isAdmin ? "Администратор" :
                        user.isModerator ? "Модератор" : "Читатель",
                    createdAt: new Date(user.createdAt.date).toLocaleString("ru-RU")
                }));
                $$("userDataTable").clearAll();
                $$("userDataTable").parse(users);
            }
        } catch (error) {
            console.log(error);
        }
    }

    editItem(id) {
        const editForm = $$("editForm");
        const item = $$("userDataTable").getItem(id);
        editForm.setValues(item);
        editForm.show();
    }

    async switchActive(id, status) {
        const payload = {
            userId: id,
            banned: status
        };

        try {
            const raw = await webix.ajax().patch(`${BASE_URL}/users/banned`, JSON.stringify(payload)).then(() => {
                webix.message("Изменено");
                this.loadUsers();
            });
            const response = await raw.json();
            checkAuthResponse(response);
        } catch (error) {
            console.log(error);
        }
    }

    async init() {
        await this.loadUsers();
    }

    ready() {
        updateToolbarButtons($$("userButton"));
    }
}