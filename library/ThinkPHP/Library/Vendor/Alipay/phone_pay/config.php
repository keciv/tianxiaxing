<?php
$config = array (	
		//应用ID,您的APPID。
		'app_id' => "2019060365501227",

		//商户私钥，您的原始格式RSA私钥
		'merchant_private_key' => "MIIEowIBAAKCAQEAs8gV2JiMX9kk5QAQgKNcUOMQQOGHABv0tKakGPsqXXZ4UPF6L16exxwePFdsxz6Qng8YK6c2GKyOweE+/W2M04Tk8JnCWDqnHs8m8zGk/hYfop6QowDRfweSpYZHSa6HgNAlSI6DC882bIcH7wpKV7Q/pPLGwA7ccbEIDruCYARf5kVMOmYFTc357bcqW+dNYnUACvSAEiwVTh1xKPBEM1a/4dH4hwgyu5YzZE3Mhrbrc4wUslDXJXQ9U2UuftV8YSKCka72CJcDrzUUCiHmJLmSYCOn0lG08X5pXLCyBrpsK32lszZlikQB2gD0vQCSKntHB3QN4VQfgMVNJqH7KQIDAQABAoIBAGZ49pLFqMV9NL1egwl/k7/7HKmOou9Z/+n0TfZ7OxOY0k14xmc3rJLbIRTN1A/hRncBLYq8PWZk/N3fsJKtHab2ybOmQJMfo2A5PP9DXcMCAzgi31g5wC+CtoCof/usgknW2ll3+ZQCoQfNE6WZnPROpjQzuTuBfP9Eo84Z7N8iyTwJx7sKtqXjV63Jtd1WUfzCQ+z2Tvh2riB8bzq7eYxHCZSwhLdKTT44HjIT91mDZ3oVRQYNLiwm3XJDcCEsZHdtKHIY8scZLYIcD84CCkskDgi0IVMipf0ogc8KorD7gxxmsMlbUj/Bact+idxJEPOz3efAT3tCGhqQjujpcnECgYEA7r+nFzHkOJU84S/aMBejOLJ9wIaAzmqJQdOFr1VEwYkAKm8VeJQsSp2smI3wo+ddLD2fIL0khl+03dm0kc2OYofVBcT3vNBcMe0pSp6uhYizKIAAqhHchuMc62oc0XETmp+StWarhrahRbUj2NqpFKier9m+Efy0wbqRuynHqxUCgYEAwMWqiZ+BsvLtrBO0CgdTihFePVmovqnoJg7yP4+Lb4h1gZiwQBsbhyCVMQluvbBxraECD1q+Eu8ersP+IeSuBHYbDlFq71ealpQ1SkeBxFekS6zftqe9EZpofUIskxIvm2n7clgmpwVWT7+ETZynBQX6bpG+u93sSKQvRSPTBMUCgYBbLutcGnv1eFoGD0afs4dtMg6BJ12ueFXvxB98tW5LFE3x5vcmVEEORmYS5bMQhl65dNd/o319rLPhPzKNtRo6W3Jqf622eUWc890fWLeC3JDAWRLn4WZ+ReNXrfFPtIYuOd/IVGwSSVIS03nbarfE4hmpQ9op+H/4tY7PEsfleQKBgBzC4SjbZYx/djqAThJY+XvWD4tzvxuDWiGjhT06e4FOiMmnMFTANqE4mUnRsHYYxz0yko4b6dQFXTyR/W6tIdGElZDTUPMYzPW+cxz8Aj57HQY1asNjz2+66/AUWXYv9m5np55tzIaK40/OsTyrLLgxJiYtFJoPCFvmMy9LowZJAoGBAJtDc+6+gRRyaB+Uvr6VYr9qVaXsnoWUCkO3oWWckKScYWpgAtVnE6A7vIJWmBmlnlCEr5bsMIV+IakML2SHNwZRzpU+gmJn3+qU+vgvjFM5ElcCQ2lIC3vSCWv7KW4JczQFa6KutgSaSGQG+a8AfU7piQoA1jh3ZOVY1QcThmlx",
		
		//异步通知地址
		'notify_url' => "http://www.jythjc.com/Alipay/notify_url.html",
		
		//同步跳转
		'return_url' => "http://www.jythjc.com/Alipay/return_url.html",

		//编码格式
		'charset' => "UTF-8",

		//签名方式
		'sign_type'=>"RSA2",

		//支付宝网关
		'gatewayUrl' => "https://openapi.alipay.com/gateway.do",

		//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
		'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAs8gV2JiMX9kk5QAQgKNcUOMQQOGHABv0tKakGPsqXXZ4UPF6L16exxwePFdsxz6Qng8YK6c2GKyOweE+/W2M04Tk8JnCWDqnHs8m8zGk/hYfop6QowDRfweSpYZHSa6HgNAlSI6DC882bIcH7wpKV7Q/pPLGwA7ccbEIDruCYARf5kVMOmYFTc357bcqW+dNYnUACvSAEiwVTh1xKPBEM1a/4dH4hwgyu5YzZE3Mhrbrc4wUslDXJXQ9U2UuftV8YSKCka72CJcDrzUUCiHmJLmSYCOn0lG08X5pXLCyBrpsK32lszZlikQB2gD0vQCSKntHB3QN4VQfgMVNJqH7KQIDAQAB",
		
	
);