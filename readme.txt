########################### products #############################
呼叫"../controllers/products.php" 來處理products相關的動作
Get參數: act
act = list: 取得某商家的產品列表
    POST 參數: name: 產品名稱
               description: 產品描述
               price: 產品價格
               userId: 商家id

act = add: 新增產品
    POST 參數: name: 產品名稱
               description: 產品描述
               price: 產品價格
               userId: 商家id

act = edit: 顯示編輯產品的畫面
    POST 參數: id: 產品id
              description: 新產品描述
              price: 新產品價格

act = delete: 刪除產品
    POST 參數: id: 產品id

########################### cart #############################
呼叫"../controllers/cart.php" 來處理cart相關的動作
Get參數: act
act = list: 取得某使用者的購物車列表
    POST 參數: userId: 使用者id

act = add: 新增購物車
    POST 參數: userId: 使用者id
               productId: 產品id
               quantity: 數量

act = remove: 刪除購物車
    POST 參數: id: 購物車id

############################ order ############################
呼叫"../controllers/order.php" 來處理order相關的動作
Get參數: act
act = list: 取得某使用者的訂單列表
    POST 參數: userId: 使用者id
    
act = add: 新增訂單
    POST 參數: userId: 使用者id
               productId: 產品id
               quantity: 數量

act = modify: 修改訂單狀態(未處理、處理中、已寄送、寄送中、已送達)
    POST 參數: id: 訂單id
               status: 訂單狀態

######################### user ###############################
呼叫"../controllers/user.php" 來處理user相關的動作
Get參數: act
act = register: 註冊
    POST 參數: username: 使用者名稱
               password: 使用者密碼
               role: 使用者角色(0: 一般使用者, 1: 商家, 2: 物流)

act = login: 登入
    POST 參數: username: 使用者名稱
               password: 使用者密碼

act = review: 評價
    POST 參數: reviewerId: 評價者id
               sellerID: 被評價者id
               rating: 評價分數(1~5)

               