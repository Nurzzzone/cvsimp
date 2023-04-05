#### Installation
- make run
- make install

```
POST /api/v1/csv/import HTTP/1.1

Content-Disposition: form-data; name="file"; filename="dataset.csv"
```

birthdate format yyyy-mm-dd
```
GET /api/v1/favorite-category?category=toys&age=20&age_range=20,30&gender=male&birthdate=1972-05-05 HTTP/1.1
Host: localhost:8080
Accept: application/json
```