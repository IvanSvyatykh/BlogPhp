import {JetView} from "webix-jet";

import MainToolBar from "./maintoolbar";
import {template} from "webix";
import {checkAuthResponse} from "../auth"

export default class Article extends JetView {
    posts = [];
    categories = [];

    translateStatus(status) {
        const map = {
            "PENDING": "Ожидает",
            "REJECTED": "Отклонён",
            "PUBLISHED": "Опубликован"
        };
        return map[status] || status;
    }

    config() {
        return {
            cols: [
                {
                    $subview: MainToolBar
                },
                {


                    view: "scrollview",
                    scroll: "y",
                    body: {
                        localId: "postsLayout",
                        rows: []
                    }

                },
                {
                    view: "form",
                    id: "postForm",
                    width: 400,
                    gravity: 1,
                    hidden: true,
                    margin: 10,
                    padding: {top: 10, right: 10, left: 10, bottom: 10},
                    css: "post_form",
                    elements: [
                        {
                            cols: [
                                {
                                    view: "button",
                                    template: `<img src = './src/styles/add.svg', class='add_button'>`,
                                    click: () => this.publishPost(id, category)
                                },

                                {
                                    rows: [
                                        {template: `<img src = './src/styles/user.svg', class='user_post_form'>`},
                                        {view: "text", name: "login", readonly: true, css: "auth-text"},
                                    ]
                                },

                                {
                                    view: "button",
                                    template: `<img src = './src/styles/delete.svg', class='add_button'>`,
                                    click: () => this.rejectPost(id)
                                }
                            ]
                        },
                        {
                            view: "text", name: "content"
                        }
                    ]
                }
            ]
        };
    }

    async loadPosts() {
        try {
            const raw = await webix.ajax().get(`${BASE_URL}/posts/list`);
            const response = await raw.json();
            checkAuthResponse(response);
            this.posts = response;
            this.renderPosts();
        } catch (error) {
            console.log(error);
        }
    }

    async init() {
        await this.loadCategories(),
            await this.loadPosts();
    }

    postItem(id) {
        const postForm = $$("postForm");
        const item = $$("userDataTable").getItem(id);
        postForm.setValues(item);
        postForm.show();
    }

    async loadCategories() {
        try {
            const raw = await webix.ajax().get(`${BASE_URL}/categories`);
            const response = await raw.json();
            checkAuthResponse(response);
            this.categories = response;

            const combo = this.$$("postForm")?.elements.find(el => el.name === "category");
            if (combo) {
                combo.define("options", this.categories);
                combo.refresh();
            }
        } catch (error) {
            console.log(error);
        }
    }

    async publishPost(id, category) {
        const payload = {
            article_id: id,
            category_name: category
        }
        try {
            const raw = await webix.ajax().patch(`${BASE_URL}/posts/publish`, JSON.stringify(payload)).then(() => {
                webix.message("Пост опубликован");
                this.loadPosts();
                $$("postForm").hide();
            });
            const response = await raw.json();
            checkAuthResponse(response);


        } catch (error) {
            console.log(error);
        }
    }

    async rejectPost(id) {
        const payload = {
            postId: id
        }
        try {
            const raw = await webix.ajax().patch(`${BASE_URL}/posts/reject`, JSON.stringify(payload)).then(() => {
                webix.message("Пост отклонен");
                this.loadPosts();
                $$("postForm").hide();
            });
            const response = await raw.json();
            checkAuthResponse(response);

        } catch (error) {
            console.log(error);
        }
    }

    renderPosts() {
        const layout = this.$$("postsLayout");
        layout.clearAll();

        const postViews = this.posts.map(post => {
            return {
                cols: [
                    {
                        rows: [
                            {
                                template: `<img src='./src/styles/user.svg' class='user_post_form'>`,
                                height: 100,
                                borderless: true
                            },
                            {view: "label", label: post.author.name, align: "center"}
                        ],
                        width: 120
                    },
                    {
                        rows: [
                            {
                                view: "label",
                                label: post.title,
                                css: "post-title"
                            },
                            {
                                view: "label",
                                label: this.translateStatus(post.status.status),
                                css: "post-status"
                            }
                        ]
                    }
                ],
                css: "post-container",
                borderless: true,
                padding: 10,
                on: {
                    onItemClick: () => this.openPostForm(post)
                }
            };
        });

        layout.addView({rows: postViews});
    }
}