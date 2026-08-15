# Laravel 12 密室

密室（Sanctum）為單一頁面應用程式（SPA）、行動應用程式和簡單的、基於權杖的 API（應用程式介面）提供輕量級身份驗證系統。密室允許應用程式的每個用戶為他們的帳號生成多個 API 權杖。這些權杖可能被授予指定允許權杖執行哪些操作的能力／範圍。

## 使用方式
- 把整個專案複製一份到你的電腦裡，這裡指的「內容」不是只有檔案，而是指所有整個專案的歷史紀錄、分支、標籤等內容都會複製一份下來。
```sh
$ git clone
```
- 將 __.env.example__ 檔案重新命名成 __.env__，如果應用程式金鑰沒有被設定的話，你的使用者 sessions 和其他加密的資料都是不安全的！
- 當你的專案中已經有 composer.lock，可以直接執行指令以讓 Composer 安裝 composer.lock 中指定的套件及版本。
```sh
$ composer install
```
- 產生 Laravel 要使用的一組 32 字元長度的隨機字串 APP_KEY 並存在 .env 內。
```sh
$ php artisan key:generate
```
- 運行單元測試和功能測試。大多數的單元測試可能只專注於單一個方法，功能測試則可以測試大部分的程式碼，包含一些物件如何進行互動，甚至是完整的 HTTP 請求到一個 JSON 端點。
```sh
$ php artisan test
```
- 執行 __Artisan__ 指令的 __migrate__ 來執行所有未完成的遷移，並執行資料庫填充（如果要測試的話）。
```sh
$ php artisan migrate --seed
```
- 在瀏覽器中輸入已定義的路由 URL 來訪問，例如：http://127.0.0.1:8000。
- 你可以經由 `/api/login/` 來進行登入。

----

## 畫面截圖
![](https://i.imgur.com/lilgjVW.png)
> 確保每次測試完都可以成功

![](https://i.imgur.com/KVW1e9Z.png)
> 傳送 HTML 表單資料使用建立使用者來做登入

![](https://i.imgur.com/8pqVVFX.png)
> 在 Authorization 請求標頭中指定存取權杖作為憑證令牌來做訂單查詢

![](https://i.imgur.com/QnPkRrw.png)
> 在 Authorization 請求標頭中指定存取權杖作為憑證令牌來做登出
