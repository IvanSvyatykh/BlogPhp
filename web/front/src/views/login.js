import { JetView } from "webix-jet";
import "webix/webix.js";

export default class Login extends JetView {
  config() {
    const apiInstnc = this.app;
    return {
      type: "clean",
      rows: [
        {},
        {
          cols: [
            {},
            {
              view: "form",
              localId: "loginForm",
              width: 400,
              rows: [
                { 
                  template: "Авторизация", 
                  type: "header", 
                  css: "auth_header" 
                },
                
                {
                  view: "layout",
                  type: "line",
                  rows: [
                    {
                      view: "label",
                      label: "Логин",
                      align: "center",
                      css: "auth-label"
                    },
                    {
                      view: "text",
                      name: "user_login",
                      required: true,
                      css: "auth_field",
                      attributes: {
                        autocomplete: "username",
                        placeholder: "Введите ваш логин"
                      }
                    }
                  ]
                },
                
                {
                  view: "layout",
                  type: "line",
                  rows: [
                    {
                      view: "label",
                      label: "Пароль",
                      align: "center",
                      css: "auth-label"
                    },
                    {
                      view: "text",
                      name: "user_password",
                      type: "password",
                      required: true,
                      css: "auth_field",
                      attributes: {
                        autocomplete: "current-password",
                        placeholder: "Введите ваш пароль"
                      }
                    }
                  ]
                },
                
                {
                  margin: 10,
                  cols: [
                    {}, 
                    {
                      view: "button",
                      value: "Войти",
                      css: "login_button",
                      type: "form",
                      click: () => this.doLogin()
                    },
                    {}
                  ]
                },
                
                {
                  template: "",
                  localId: "message",
                  css: "error-message",
                  borderless: true,
                  height: 40
                }
              ],
              rules: {
                user_login: webix.rules.isNotEmpty,
                user_password: webix.rules.isNotEmpty
              }
            },
            {}
          ]
        },
        {}
      ]
    };

  }

  async doLogin() {
    const form = this.$$("loginForm");

    if (form.validate()) {
      const values = form.getValues();

      try {
        const raw = await webix.ajax().post(`${BASE_URL}/login`, values);
        const response = raw.json();

        const token = response.token;
        localStorage.setItem("jwt_token", token);

        this.app.show("/main");
      } catch (error) {
        const message = error?.response?.text || "Ошибка авторизации";
        webix.message({ type: "error", text: message });
        console.log(message);
      }
    }
  }

}
