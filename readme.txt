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
*/
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

