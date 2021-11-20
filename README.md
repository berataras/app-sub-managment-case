
## Register

- Device kayıt ettrir ve geriye oluşturduğu device token'ı döner.
- İlgili device herhangi bir app'e kayıt olmak isterse, bu token'ı daha sonradan Bearer token olarak, Header kısmından göndermelidir.

```http
  POST /api/register
```

| Parametre | Tip     |
| :-------- | :------- | 
| `uid` | `int` |
| `language` | `string` |
| `os` | `string` |


## Create Subscription

- Receipt son iki rakan 6'ya bölünüyorsa ios, google rate_limit döndürür.
- Receipt'in son rakamı tek ise googe ve ios doğrulanır.
- Eğer sub ise ve expire_date'i daha dolmamışsa tekrar sub olamaz.
- İki event bulunur: renewed ve started. Bu event'lar belirli olaylar sırasında tetiklenir.

```http
  POST /api/subscription/create
```

| Parametre | Tip     |
| :-------- | :------- | 
| `app_id` | `int` |
| `receipt` | `any` |

| Headers | Example     |
| :-------- | :------- | 
| `Authorization` | `Bearer 08d7475da4a8343290e35c490e7ee0e4f5fe88c7` |


## Check Subscription

- Sub'ın expire_date'i dolmuşsa status false'lanır ve canceled event'ı tetiklenir ve geriye sub durumu döndürülür.
- Sub'ın expire_date'i geçmemişse direkt durumu döndürülür.

```http
  POST /api/subscription/check
```

| Parametre | Tip     |
| :-------- | :------- | 
| `app_id` | `int` |

| Headers | Example     |
| :-------- | :------- | 
| `Authorization` | `Bearer 08d7475da4a8343290e35c490e7ee0e4f5fe88c7` |

## Report

- Normal raport ve excel export seçenekleri vardır.

```http
  GET /api/report
```

```http
  GET /api/report/excel
```
