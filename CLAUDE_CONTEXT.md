# CLAUDE_CONTEXT.md
> Этот файл даёт Claude контекст проекта. Кидай его в начале каждого нового чата.
> Обновляй статус задач по мере продвижения.

---

## Проект
- **Название:** Коды&Купоны
- **URL:** promo.loc (локально), продакшн домен уточнить
- **Фреймворк:** Laravel 13 (чистая установка, без стартового кита)
- **Цель:** Запустить как можно скорее, без перфекционизма и получать вознаграждения от партнёрок
- **Контекст:** Соло-проект, разрабатывается локально в OSPanel 6

---

## Стек
- **Backend:** Laravel 13, PHP 8.5
- **Админка:** Filament v4 (выбран вместо MoonShine)
- **Frontend:** Blade + Tailwind CSS 4
- **Интерактив:** Livewire (только для живого поиска на публичном фронте)
- **Сборка:** Vite
- **БД:** MySQL (локально через OSPanel 6)
- **Локальная разработка:** OSPanel 6, Apache (не Nginx — Nginx не проксирует Laravel-роуты без кастомного конфига домена, Apache работает из коробки)

---

## Аутентификация
- Стандартный Laravel Auth **не используется** — удалён при переустановке
- Публичная часть сайта — без авторизации пользователей
- Админка — Filament со своей системой аутентификации (своя таблица, свой guard)
- Публичной регистрации пользователей нет

---

## Сущности и связи
- **Shop** 1 → N **Offer**
- **Offer** N → N **Category** (через `category_offer`)
- **Offer** 1 → N **Click**

Офферы показываются только в листингах (главная, страница магазина, страница категории).
**Отдельных страниц офферов нет** — детали показываются в модальном окне при клике.

---

## Соглашения проекта
- Boolean поля именуются `is_active` (не `active`, не `status`)
- `restrictOnDelete()` на важных FK (offers→shops, clicks→offers) — защита аналитики
- `cascadeOnDelete()` только на `category_offer` — это просто связующая таблица
- Партнёрские сети — PHP enum, отдельной таблицы нет (хранить там нечего кроме названия)
- `external_id` хранится как `string` — универсально для всех форматов ID партнёрок
- Индексы добавляются только там где реально нужны, без преждевременной оптимизации
- Яндекс Метрика — для поведенческой аналитики (устройства, источники, уники)
- Внутренняя таблица `clicks` — только для бизнес-аналитики офферов (рейтинг, конверсия)
- Скоупы и касты добавляются только при реальной необходимости — не заранее
- CTA на кнопке офферов универсальный — «Воспользоваться» (поле `type` не нужно)
- `meta_title` не добавлен в миграции — планируется добавить в `shops` и `categories` позже (nullable, если пустое — генерируется по шаблону)

---

## Filament v4 — важные детали

- Установлен через `composer require filament/filament:"^4.0" -W`
- Панель создана через `php artisan filament:install --panels`, ID панели — `admin`
- Пользователь админки создан через `php artisan make:filament-user`
- В **v4 структура ресурса разбита по папкам**: `Resources/Shops/Schemas/`, `Resources/Shops/Tables/`, `Resources/Shops/Pages/` — не монолитный файл как в v3
- Акцентный цвет — `Color::Cyan` в `AdminPanelProvider`
- Связь Many-to-Many в форме оффера через `Select::make('categories')->relationship('categories', 'name')->multiple()->preload()` — Filament сам пишет в `category_offer`
- Enum для партнёрских сетей создан и подключён к OfferResource

---

## Схема БД

### shops
| Поле | Тип | Описание |
|------|-----|----------|
| id | bigint | PK |
| is_active | boolean | default false |
| slug | string | unique, вводится вручную |
| title | string | Название магазина |
| alt_title | string, nullable | Альтернативное название (ВБ, Купер и т.д.) — только для отображения |
| description | text, nullable | Описание магазина |
| url | string | unique, сайт магазина |
| logo | string, nullable | Путь к логотипу |
| aliases | text, nullable | Альтернативные названия через запятую — для живого поиска |
| seo_text | text, nullable | SEO-текст внизу страницы |
| sort | unsignedInteger | default 999 |
| timestamps | | |
| **Индексы** | | `['is_active', 'sort']` |

### offers
| Поле | Тип | Описание |
|------|-----|----------|
| id | bigint | PK |
| shop_id | FK → shops | restrictOnDelete |
| title | string(256) | Название оффера |
| description | string(500), nullable | Короткое описание |
| starts_at | timestamp, nullable | Дата начала |
| expires_at | timestamp, nullable | Дата окончания |
| discount | string, nullable | Скидка одним полем ("15%", "500 ₽") |
| promocode | string, nullable | Сам промокод, nullable если просто акция |
| url | string(2048) | Партнёрская ссылка |
| manual_sort | unsignedInteger | default 10, места 0-9 зарезервированы для топ-офферов |
| rating | decimal(4,2), nullable | Рейтинг, обновляется кроном раз в сутки |
| is_moderated | boolean | default false, нужен для будущего автоимпорта |
| is_active | boolean | default true |
| partner_network | string(50) | Партнёрская сеть (PHP enum), NOT NULL |
| external_id | string, nullable | ID оффера в партнёрской сети |
| timestamps | | |
| **Индексы** | | `['shop_id', 'is_active', 'is_moderated']` |

### categories
| Поле | Тип | Описание |
|------|-----|----------|
| id | bigint | PK |
| slug | string | unique |
| name | string | unique |
| is_active | boolean | default false |
| seo_text | text, nullable | SEO-текст внизу страницы категории |
| sort | unsignedInteger | default 999 |
| timestamps | | |

> Индексов нет — категорий максимум ~200, индексы не нужны

### category_offer
| Поле | Тип | Описание |
|------|-----|----------|
| category_id | FK → categories | cascadeOnDelete |
| offer_id | FK → offers | cascadeOnDelete |
| **Primary key** | | `['category_id', 'offer_id']` — category_id первым т.к. основной запрос по категории |

> Нет id, нет timestamps — просто связующая таблица

### clicks
| Поле | Тип | Описание |
|------|-----|----------|
| id | bigint | PK |
| offer_id | FK → offers | restrictOnDelete |
| timestamps | | created_at = время клика |
| **Индексы** | | `['offer_id', 'created_at']` — для подсчёта кликов за период |

> shop_id намеренно убран — получается через offer→shop_id, денормализация не нужна

---

## Модели

### Shop
```php
class Shop extends Model
{
    protected $fillable = [
        'is_active', 'slug', 'title', 'alt_title', 'description',
        'url', 'logo', 'aliases', 'seo_text', 'sort',
    ];

    public function offers(): HasMany
    {
        return $this->hasMany(Offer::class);
    }
}
```
> Без кастов (нет API/Inertia), без скоупов (логика пока простая)

---

### Offer
```php
class Offer extends Model
{
    protected $fillable = [
        'shop_id', 'title', 'description', 'starts_at', 'expires_at',
        'discount', 'promocode', 'url', 'manual_sort', 'rating',
        'is_moderated', 'is_active', 'partner_network', 'external_id',
    ];

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function clicks(): HasMany
    {
        return $this->hasMany(Click::class);
    }

    public function scopePublished($query)
    {
        return $query->where('is_active', true)
                     ->where('is_moderated', true)
                     ->where(function ($q) {
                         $q->whereNull('expires_at')
                           ->orWhere('expires_at', '>', now());
                     });
    }
}
```
> `scopePublished` — единственный скоуп, покрывает все три условия видимости оффера на сайте.
> Используется везде: `Offer::published()->get()`, `$shop->offers()->published()->get()`

---

### Category
```php
class Category extends Model
{
    protected $fillable = [
        'slug', 'name', 'is_active', 'seo_text', 'sort',
    ];

    public function offers(): BelongsToMany
    {
        return $this->belongsToMany(Offer::class);
    }
}
```
> Без кастов и скоупов — модель простая

---

### Click
```php
class Click extends Model
{
    protected $fillable = [
        'offer_id',
    ];

    public function offer(): BelongsTo
    {
        return $this->belongsTo(Offer::class);
    }
}
```
> Минимальная модель. Поля ip, user_agent, referer добавятся на этапе аналитики.

---

## Роут кликов
```
Пользователь кликает → /go/{offer} → пишем Click в БД → redirect на партнёрскую ссылку
```
Всё на сервере, без JS. Цель в Яндекс Метрике отправляется отдельно.

---

## Использование категорий
Категории нужны для:
1. SEO-страниц `/category/slug`
2. Блоков на главной ("Скидки на еду")
3. Внутренней перелинковки ("Похожие акции")
4. Sitemap

Фильтрация по категориям на странице магазина — **не планируется** (нецелесообразно).
На странице категории показываются **офферы**, не магазины.

---

## Статус задач
- [x] Определена архитектура проекта
- [x] Выбран стек (Laravel 13, Filament v4, Livewire, Tailwind 4)
- [x] Чистая установка Laravel без стартового кита
- [x] Настроен OSPanel 6 (project.ini, public_dir)
- [x] Миграции спроектированы и применены (shops, offers, categories, category_offer, clicks)
- [x] Созданы модели с связями (Shop, Offer, Category, Click)
- [x] Установлен и настроен Filament v4 (панель admin, пользователь создан, акцентный цвет Cyan)
- [x] Решена проблема 404 в OpenServer — переключились с Nginx на Apache
- [x] Создан ShopResource (работает, тестовая запись добавлена)
- [x] Создан OfferResource (работает, тестовая запись добавлена, enum партнёрки подключён)
- [x] Создан CategoryResource (работает, тестовая запись добавлена)
- [x] В OfferResource добавлен мультиселект категорий через relationship (пишет в category_offer)
- [ ] Наполнить магазины и категории SEO-текстами (контент, отдельный чат)
- [ ] Роут /go/{offer} и контроллер Click
- [ ] Публичный фронт (Blade + Tailwind)
- [ ] Livewire живой поиск
- [ ] Деплой

---

## Как использовать этот файл
1. Скопируй содержимое файла
2. В начале нового чата напиши: _"Вот контекст моего проекта:"_ и вставь содержимое
3. В конце чата попроси: _"Обнови CLAUDE_CONTEXT.md с учётом того, что мы сделали"_
4. Скопируй обновлённую версию обратно в файл
