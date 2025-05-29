import { JetView } from "webix-jet";

import MainToolBar from "./maintoolbar";
import { template } from "webix";
import { checkAuthResponse } from "../auth"
import { updateToolbarButtons } from "../utils";

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
                    localId: "postForm",
                    width: 600,
                    hidden: true,
                    margin: 10,
                    padding: { top: 10, right: 10, left: 10, bottom: 10 },
                    css: "post_form",
                    elements: [
                        {
                            cols: [
                                {
                                    rows: [
                                        {
                                            template: `
                                                <div style='text-align:center'>
                                                    <img src='./src/styles/user.svg' class='user_post_edit_form' style='width:60px;height:60px;'/>
                                                </div>`,
                                            borderless: true,
                                            height: 70
                                        },
                                        {
                                            cols: [
                                                {},
                                                {
                                                    view: "label",
                                                    localId: "postAuthorLabel",
                                                    label: "",
                                                    align: "center",
                                                    css: "auth-text"
                                                },
                                                {}
                                            ]
                                        },
                                        { height: 10 }
                                    ]
                                },
                                { width: 30 }
                            ]
                        },
                        
                        {
                            cols: [
                                {
                                    
                                    rows: [
                                        {
                                            template: "<div style='text-align:center;'>Категория</div>",
                                            borderless: true,
                                            height: 40
                                        },
                                        {
                                            view: "combo",
                                            name: "category",
                                            localId: "categoryCombo",
                                            placeholder: "Выберите категорию",
                                            options: [],
                                            required: true,
                                            height: 50
                                        },
                                        {
                                            view: "textarea",
                                            name: "content",
                                            height: 150,
                                            readonly: true,
                                            css: "readonly-area"
                                        }
                                    ]
                                },
                                { width: 30 }
                            ]
                        },
                        
                        {
                            cols: [
                                
                                {
                                    view: "button",
                                    localId: "publishBtn",
                                    width: 50,
                                    css: "icon-button",
                                    tooltip: "Опубликовать",
                                    template: `<img src='./src/styles/add.svg' class='add_button'>`,
                                    click: () => {
                                        const form = this.$$("postForm");
                                        const values = form.getValues();
                                        this.publishPost(values.id, values.category);
                                    }
                                },
                                {},
                                {
                                    view: "button",
                                    localId: "rejectBtn",
                                    width: 50,
                                    css: "icon-button",
                                    tooltip: "Отклонить",
                                    template: `<img src='./src/styles/delete.svg' class='add_button'>`,
                                    click: () => {
                                        const form = this.$$("postForm");
                                        const values = form.getValues();
                                        this.rejectPost(values.id);
                                    }
                                }
                                
                            ]
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

            const combo = this.$$("categoryCombo");
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
            const raw = await webix.ajax().patch(`${BASE_URL}/posts/publish`, JSON.stringify(payload));
            const response = await raw.json();
            checkAuthResponse(response);
            webix.message("Пост опубликован");
            await this.loadPosts();
            this.$$("postForm").hide();
        } catch (error) {
            webix.message(error.responseText);
            console.log(error);
        }
    }

    async rejectPost(id) {
        const payload = {
            postId: id
        }
        try {
            const raw = await webix.ajax().patch(`${BASE_URL}/posts/reject`, JSON.stringify(payload));
            const response = await raw.json();

            webix.message("Пост отклонен");
            this.loadPosts();
            this.$$("postForm").hide();
        } catch (error) {
            console.log(error);
        }
    }

    renderPosts() {
        const layout = this.$$("postsLayout");
        layout.getChildViews().forEach(v => layout.removeView(v));


        const postViews = this.posts.map(post => {
            return {
                cols: [
                    {
                        rows: [
                            {
                                view: "button",
                                template: `<img src='./src/styles/user.svg' class='user_post_form'>`,
                                height: 50,
                                borderless: true,
                                click: () => {
                                    this.openPostForm(post);
                                }
                            },
                            { view: "label", label: post.author.name, align: "center" }
                        ],
                        width: 120
                    },
                    {
                        cols: [
                            {
                                view: "text",
                                name: "id",
                                hidden: true
                            },

                            {
                                view: "label",
                                label: post.title,
                                css: "post-title",
                                align: "center"
                            },
                            {
                                view: "label",
                                label: this.translateStatus(post.status.status),
                                css: "post-status",
                                align: "center"
                            }
                        ]
                    }
                ],
                css: "post-container",
                borderless: true,
                padding: 10
            };
        });

        layout.addView({ rows: postViews });
    }

    openPostForm(post) {
        const form = this.$$("postForm");
        form.setValues({
            id: post.id,
            content: post.content,
            category: this.categories.includes(post.type?.type) ? post.type.type : ""
        });
        this.$$("postAuthorLabel").setValue(post.author.name);
        form.show();
    }
    ready() {
        updateToolbarButtons($$("articleButton"));
    }
}