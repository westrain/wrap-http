wrap-http
Обернутый curl)
удобно использовать

(new WrapHttp())
->url('mysite.com')
->methods('post')
->params([
  'message'=>'hello world'
])
->send()
->response();
