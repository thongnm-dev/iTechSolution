<?php

namespace Database\Seeders;

use App\Models\AboutContent;
use App\Models\AboutStat;
use App\Models\AboutValue;
use App\Models\Category;
use App\Models\Post;
use App\Models\Project;
use App\Models\Service;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

/**
 * Demo content seeder (no Faker, safe to run in a --no-dev production image).
 * Downloads a fixed set of Unsplash coding/dev photos into the public disk
 * so cover images work the same way as a real Filament upload would.
 */
class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        $author = User::firstOrCreate(
            ['email' => 'test@example.com'],
            ['name' => 'Test User', 'password' => Hash::make('password')],
        );

        $categories = collect([
            ['name' => 'Web Development', 'slug' => 'web-development'],
            ['name' => 'Backend Engineering', 'slug' => 'backend-engineering'],
            ['name' => 'Programming Tips', 'slug' => 'programming-tips'],
        ])->map(fn (array $data) => Category::firstOrCreate(['slug' => $data['slug']], $data));

        $tags = collect(['Laravel', 'Vue.js', 'PHP', 'JavaScript', 'DevOps', 'Best Practices'])
            ->mapWithKeys(fn (string $name) => [
                $name => Tag::firstOrCreate(['slug' => str($name)->slug()], ['name' => $name, 'slug' => str($name)->slug()]),
            ]);

        $posts = [
            [
                'title' => 'Xây dựng API RESTful với Laravel 13',
                'category' => 'backend-engineering',
                'tags' => ['Laravel', 'PHP', 'Best Practices'],
                'excerpt' => 'Hướng dẫn thiết kế API RESTful rõ ràng, dễ mở rộng với Laravel 13, từ routing, resource cho đến xử lý lỗi.',
                'image' => 'photo-1461749280684-dccba630e2f6',
                'contentImage' => 'photo-1515879218367-8466d910aaa4',
                'content' => <<<'HTML'
                    <p>Laravel cung cấp bộ công cụ đầy đủ để xây dựng API RESTful chuẩn chỉnh: route model binding, API Resource, Form Request validation và Sanctum cho xác thực token. Trong bài viết này, chúng ta sẽ đi qua từng bước xây dựng một API quản lý bài viết, từ việc định nghĩa route, viết controller, đến chuẩn hóa response bằng Resource class để tách biệt hoàn toàn dữ liệu database khỏi định dạng trả về cho client.</p>
                    <h2>1. Định nghĩa route và controller</h2>
                    <p>Mọi endpoint nên được khai báo trong <code>routes/api.php</code> và trỏ tới một controller chuyên trách. Việc tách controller theo resource (Post, Category, Tag...) giúp code dễ đọc và dễ bảo trì hơn khi dự án phình to.</p>
                    {{CONTENT_IMAGE}}
                    <h3>Route model binding</h3>
                    <p>Thay vì tự query theo id trong từng action, Laravel cho phép binding trực tiếp model vào tham số route, giảm đáng kể code lặp lại và tự động trả về 404 khi không tìm thấy bản ghi.</p>
                    <h2>2. Chuẩn hóa response với API Resource</h2>
                    <p>API Resource là lớp trung gian giúp kiểm soát chính xác những trường nào được trả về client, tránh rò rỉ dữ liệu nhạy cảm và giữ hợp đồng API ổn định ngay cả khi schema database thay đổi.</p>
                    <ul>
                        <li>Ẩn các cột nội bộ như <code>id</code> tăng dần dễ đoán nếu cần</li>
                        <li>Đổi tên trường theo chuẩn camelCase cho frontend</li>
                        <li>Nhúng quan hệ (category, tags, author) một cách tường minh</li>
                        <li>Tính toán thêm các trường phái sinh như <code>minutesToRead</code></li>
                    </ul>
                    <blockquote><p>Nguyên tắc vàng: controller không bao giờ trả thẳng Model ra ngoài, luôn đi qua Resource.</p></blockquote>
                    <h2>3. Xác thực và bảo vệ endpoint</h2>
                    <p>Với các endpoint cần đăng nhập (ví dụ khu vực quản trị), Laravel Sanctum cung cấp cơ chế token đơn giản và an toàn, phù hợp cho cả SPA lẫn mobile app mà không cần thiết lập OAuth phức tạp.</p>
                    <p>Kết hợp Form Request để validate input, Resource để chuẩn hóa output, và Sanctum để bảo vệ endpoint, bạn đã có đủ nền tảng để xây dựng một API RESTful vững chắc cho dự án thực tế.</p>
                    HTML,
            ],
            [
                'title' => '10 mẹo tối ưu hiệu năng Vue 3',
                'category' => 'web-development',
                'tags' => ['Vue.js', 'JavaScript', 'Best Practices'],
                'excerpt' => 'Tổng hợp các kỹ thuật tối ưu render, quản lý state và code-splitting giúp ứng dụng Vue 3 chạy nhanh và mượt hơn.',
                'image' => 'photo-1542831371-29b0f74f9713',
                'contentImage' => 'photo-1614741118887-7a4ee193a5fa',
                'content' => <<<'HTML'
                    <p>Vue 3 với Composition API mang lại hiệu năng tốt hơn đáng kể so với Vue 2, nhưng để khai thác tối đa vẫn cần một số kỹ thuật tối ưu ở tầng ứng dụng. Bài viết tổng hợp 10 mẹo thực chiến giúp giảm thời gian render và kích thước bundle.</p>
                    <h2>Tối ưu render</h2>
                    <ul>
                        <li>Dùng <code>v-memo</code> cho danh sách lớn ít thay đổi</li>
                        <li>Tránh watcher sâu (<code>deep: true</code>) khi không thực sự cần thiết</li>
                        <li>Ưu tiên <code>computed</code> thay vì tính toán lại trong template</li>
                        <li>Dùng <code>v-once</code> cho nội dung tĩnh không đổi</li>
                    </ul>
                    {{CONTENT_IMAGE}}
                    <h2>Tối ưu bundle size</h2>
                    <p>Chia nhỏ code theo route bằng dynamic import giúp trình duyệt chỉ tải phần cần thiết cho trang hiện tại, thay vì toàn bộ ứng dụng ngay từ lần truy cập đầu tiên.</p>
                    <h3>Lazy-load route</h3>
                    <p>Vue Router hỗ trợ khai báo component dạng <code>() =&gt; import('./View.vue')</code>, Vite sẽ tự động tách thành chunk riêng và chỉ tải khi người dùng điều hướng tới route đó.</p>
                    <blockquote><p>Đo trước khi tối ưu: Lighthouse và Vue Devtools Performance tab là hai công cụ không thể thiếu.</p></blockquote>
                    <h2>Quản lý state hợp lý</h2>
                    <p>Không phải state nào cũng cần đưa vào Pinia toàn cục. Với state chỉ dùng trong một cụm component nhỏ, <code>provide/inject</code> hoặc props đơn giản thường đủ và dễ theo dõi hơn.</p>
                    <p>Áp dụng đồng thời các kỹ thuật trên, một ứng dụng Vue 3 cỡ trung bình có thể giảm đáng kể thời gian tải trang đầu và cải thiện rõ rệt điểm Core Web Vitals.</p>
                    HTML,
            ],
            [
                'title' => 'Container hóa ứng dụng Laravel với Docker',
                'category' => 'backend-engineering',
                'tags' => ['DevOps', 'Laravel'],
                'excerpt' => 'Từ Dockerfile multi-stage đến docker-compose: cách đóng gói một ứng dụng Laravel + Nginx + MySQL để triển khai production.',
                'image' => 'photo-1607706189992-eae578626c86',
                'contentImage' => 'photo-1498050108023-c5249f4df085',
                'content' => <<<'HTML'
                    <p>Đóng gói một ứng dụng Laravel bằng Docker giúp môi trường chạy nhất quán giữa local, staging và production — không còn cảnh "chạy được trên máy tôi nhưng lỗi trên server".</p>
                    <h2>Multi-stage build</h2>
                    <p>Một Dockerfile production tốt thường tách thành nhiều stage: build frontend, cài đặt dependency PHP qua Composer, và stage cuối cùng chỉ chứa những gì thực sự cần để chạy ứng dụng — giúp image nhỏ gọn và an toàn hơn.</p>
                    {{CONTENT_IMAGE}}
                    <h3>PHP-FPM và Nginx trong cùng container</h3>
                    <p>Khi cần gộp cả web server và PHP process trong một image, <code>supervisord</code> là lựa chọn phổ biến để quản lý đồng thời nhiều tiến trình mà không cần container riêng cho từng thành phần.</p>
                    <ul>
                        <li>Nginx phục vụ static asset và forward request PHP tới PHP-FPM</li>
                        <li>PHP-FPM xử lý các request động của Laravel</li>
                        <li>Supervisord đảm bảo cả hai tiến trình tự khởi động lại nếu crash</li>
                    </ul>
                    <h2>Orchestrate với docker-compose</h2>
                    <p>Kết hợp thêm service MySQL với healthcheck, ứng dụng chỉ khởi động khi database đã sẵn sàng, tránh lỗi kết nối trong những giây đầu tiên container chạy.</p>
                    <blockquote><p>Luôn tách biệt biến môi trường nhạy cảm (APP_KEY, DB_PASSWORD) ra khỏi image, truyền vào lúc chạy container thay vì bake cứng vào lúc build.</p></blockquote>
                    <p>Với cách tiếp cận này, việc triển khai một bản release mới chỉ còn là build image, push lên registry và chạy lại container — nhanh, nhất quán và dễ rollback.</p>
                    HTML,
            ],
            [
                'title' => 'So sánh Composition API và Options API trong Vue',
                'category' => 'web-development',
                'tags' => ['Vue.js', 'JavaScript'],
                'excerpt' => 'Khi nào nên dùng Composition API, khi nào Options API vẫn là lựa chọn hợp lý cho dự án của bạn.',
                'image' => 'photo-1607799279861-4dd421887fb3',
                'contentImage' => 'photo-1504639725590-34d0984388bd',
                'content' => <<<'HTML'
                    <p>Composition API mang lại khả năng tái sử dụng logic tốt hơn thông qua composable, đặc biệt hữu ích với các component phức tạp có nhiều state và side-effect đan xen nhau.</p>
                    <h2>Ưu điểm của Composition API</h2>
                    <ul>
                        <li>Nhóm logic liên quan lại gần nhau thay vì tách theo option (data, methods, computed...)</li>
                        <li>Dễ trích xuất thành composable để tái sử dụng giữa nhiều component</li>
                        <li>Hỗ trợ TypeScript tốt hơn nhờ suy luận kiểu tự nhiên</li>
                    </ul>
                    {{CONTENT_IMAGE}}
                    <h2>Khi nào Options API vẫn hợp lý</h2>
                    <p>Với các component đơn giản, chủ yếu là hiển thị dữ liệu tĩnh, Options API vẫn dễ đọc và dễ tiếp cận hơn với người mới bắt đầu học Vue, vì cấu trúc rõ ràng theo từng nhóm chức năng có sẵn.</p>
                    <h3>Ví dụ thực tế</h3>
                    <p>Một component hiển thị thông tin người dùng tĩnh không cần composable phức tạp — Options API vẫn là lựa chọn đủ tốt. Ngược lại, một component bảng dữ liệu có filter, sort, phân trang và gọi API liên tục sẽ hưởng lợi rõ rệt từ Composition API.</p>
                    <blockquote><p>Không có "đúng tuyệt đối" — chọn API phù hợp với độ phức tạp thực tế của component.</p></blockquote>
                    <p>Nhiều dự án hiện nay dùng kết hợp: Options API cho component đơn giản, Composition API cho phần lõi nghiệp vụ phức tạp — miễn là nhất quán trong cùng một team.</p>
                    HTML,
            ],
            [
                'title' => 'Bảo mật ứng dụng web: những nguyên tắc cơ bản',
                'category' => 'programming-tips',
                'tags' => ['Best Practices', 'PHP'],
                'excerpt' => 'Checklist bảo mật cơ bản mọi lập trình viên backend nên nắm: validation, escaping, CSRF, rate limiting.',
                'image' => 'photo-1555066931-4365d14bab8c',
                'contentImage' => 'photo-1515879218367-8466d910aaa4',
                'content' => <<<'HTML'
                    <p>Phần lớn lỗ hổng bảo mật web đến từ việc thiếu validate đầu vào và tin tưởng dữ liệu từ client. Bài viết đi qua các nguyên tắc nền tảng mà mọi lập trình viên backend nên nắm vững.</p>
                    <h2>1. Không bao giờ tin dữ liệu từ client</h2>
                    <p>Mọi input — từ form, query string, header hay file upload — đều cần được validate và sanitize trước khi xử lý hoặc lưu trữ, kể cả khi frontend đã validate rồi.</p>
                    {{CONTENT_IMAGE}}
                    <h2>2. Chống SQL injection</h2>
                    <p>Sử dụng Eloquent ORM hoặc query builder với parameter binding thay vì nối chuỗi SQL thủ công gần như loại bỏ hoàn toàn nguy cơ SQL injection.</p>
                    <h2>3. CSRF và rate limiting</h2>
                    <ul>
                        <li>Bật CSRF protection cho mọi form thay đổi dữ liệu (POST/PUT/DELETE)</li>
                        <li>Giới hạn rate limit cho các endpoint nhạy cảm như đăng nhập, quên mật khẩu, form liên hệ</li>
                        <li>Log và cảnh báo khi phát hiện số lượng request bất thường từ một IP</li>
                    </ul>
                    <blockquote><p>Bảo mật không phải một tính năng thêm vào cuối dự án — nó phải là một phần của thiết kế ngay từ đầu.</p></blockquote>
                    <p>Áp dụng đầy đủ các nguyên tắc trên không đảm bảo an toàn tuyệt đối, nhưng sẽ loại bỏ phần lớn các lỗ hổng phổ biến nhất mà kẻ tấn công thường khai thác.</p>
                    HTML,
            ],
            [
                'title' => 'Từ Monolith đến Microservices: khi nào nên chuyển đổi',
                'category' => 'backend-engineering',
                'tags' => ['DevOps', 'Best Practices'],
                'excerpt' => 'Microservices không phải lúc nào cũng là lựa chọn đúng. Cùng phân tích thời điểm và điều kiện nên cân nhắc.',
                'image' => 'photo-1605379399642-870262d3d051',
                'contentImage' => 'photo-1614741118887-7a4ee193a5fa',
                'content' => <<<'HTML'
                    <p>Kiến trúc microservices giải quyết tốt bài toán scale độc lập từng phần và cho phép nhiều team làm việc song song, nhưng đổi lại là chi phí vận hành và độ phức tạp tăng lên đáng kể.</p>
                    <h2>Chi phí thực sự của microservices</h2>
                    <ul>
                        <li>Cần hạ tầng orchestration (Kubernetes, service mesh...)</li>
                        <li>Giao tiếp giữa các service phức tạp hơn, cần xử lý lỗi mạng, retry, timeout</li>
                        <li>Debug và theo dõi (tracing) một request xuyên suốt nhiều service khó hơn nhiều</li>
                        <li>Cần đội ngũ DevOps đủ kinh nghiệm để vận hành ổn định</li>
                    </ul>
                    {{CONTENT_IMAGE}}
                    <h2>Khi nào một monolith vẫn tốt hơn</h2>
                    <p>Với đa số dự án vừa và nhỏ, một monolith được tổ chức tốt — module hóa rõ ràng theo domain, ranh giới giữa các module tách bạch — vẫn là lựa chọn tối ưu hơn về chi phí và tốc độ phát triển.</p>
                    <h3>Dấu hiệu nên cân nhắc tách microservices</h3>
                    <p>Khi một module cụ thể cần scale độc lập với tải rất khác biệt so với phần còn lại của hệ thống, hoặc khi nhiều team lớn liên tục đụng độ khi làm việc trên cùng một codebase, đó là lúc nên bắt đầu cân nhắc tách dần từng phần thành service riêng.</p>
                    <blockquote><p>Bắt đầu với monolith module hóa tốt, chỉ tách microservices khi có lý do kinh doanh hoặc kỹ thuật rõ ràng — không tách vì "nghe nói nó hiện đại hơn".</p></blockquote>
                    HTML,
            ],
        ];

        foreach ($posts as $index => $data) {
            $contentImageUrl = Storage::disk('public')->url($this->storeUnsplashImage($data['contentImage'], 'posts'));
            $contentImageTag = '<img src="'.$contentImageUrl.'" alt="'.e($data['title']).'">';
            $content = str_replace('{{CONTENT_IMAGE}}', $contentImageTag, $data['content']);

            $post = Post::updateOrCreate(
                ['slug' => str($data['title'])->slug()],
                [
                    'title' => $data['title'],
                    'excerpt' => $data['excerpt'],
                    'content' => $content,
                    'cover_image' => $this->storeUnsplashImage($data['image'], 'posts'),
                    'category_id' => $categories->firstWhere('slug', $data['category'])->id,
                    'author_id' => $author->id,
                    'status' => 'published',
                    'published_at' => now()->subDays(count($posts) - $index),
                ],
            );

            $post->tags()->sync(collect($data['tags'])->map(fn (string $name) => $tags[$name]->id));
        }

        $services = [
            ['icon' => 'pi-code', 'title' => 'Phát triển Web', 'description' => 'Xây dựng website và ứng dụng web hiện đại, hiệu năng cao với Vue.js và Laravel.'],
            ['icon' => 'pi-mobile', 'title' => 'Ứng dụng di động', 'description' => 'Thiết kế và phát triển ứng dụng di động đa nền tảng cho iOS và Android.'],
            ['icon' => 'pi-server', 'title' => 'Giải pháp Backend & API', 'description' => 'Xây dựng hệ thống backend, API RESTful ổn định, bảo mật và dễ mở rộng.'],
            ['icon' => 'pi-cloud', 'title' => 'Triển khai & DevOps', 'description' => 'Container hóa, CI/CD và triển khai hạ tầng cloud cho ứng dụng của bạn.'],
        ];

        foreach ($services as $order => $data) {
            Service::firstOrCreate(['title' => $data['title']], [...$data, 'order' => $order]);
        }

        $projects = [
            ['title' => 'Hệ thống quản lý bán hàng iTech POS', 'category' => 'Web Application', 'description' => 'Giải pháp quản lý bán hàng đa chi nhánh, tồn kho thời gian thực và báo cáo doanh thu.', 'image' => 'photo-1580927752452-89d86da3fa0a'],
            ['title' => 'Ứng dụng đặt lịch khám bệnh trực tuyến', 'category' => 'Mobile App', 'description' => 'Ứng dụng di động giúp bệnh nhân đặt lịch, nhận nhắc hẹn và xem hồ sơ khám bệnh.', 'image' => 'photo-1628258334105-2a0b3d6efee1'],
            ['title' => 'Nền tảng thương mại điện tử đa kênh', 'category' => 'E-commerce', 'description' => 'Nền tảng bán hàng đồng bộ tồn kho và đơn hàng trên nhiều sàn thương mại điện tử.', 'image' => 'photo-1619410283995-43d9134e7656'],
            ['title' => 'Cổng thông tin doanh nghiệp nội bộ', 'category' => 'Enterprise Portal', 'description' => 'Cổng thông tin nội bộ tập trung quy trình phê duyệt, tài liệu và thông báo nhân sự.', 'image' => 'photo-1534972195531-d756b9bfa9f2'],
        ];

        foreach ($projects as $order => $data) {
            Project::firstOrCreate(['title' => $data['title']], [
                'title' => $data['title'],
                'category' => $data['category'],
                'description' => $data['description'],
                'image' => $this->storeUnsplashImage($data['image'], 'projects'),
                'order' => $order,
            ]);
        }

        $about = AboutContent::current();
        $about->fill([
            'hero_title' => 'Về iTechSolution',
            'hero_subtitle' => 'Đối tác công nghệ đáng tin cậy cho doanh nghiệp của bạn',
            'story_paragraph_1' => 'iTechSolution được thành lập với mong muốn mang giải pháp công nghệ chất lượng, phù hợp với từng bài toán thực tế của doanh nghiệp Việt Nam.',
            'story_paragraph_2' => 'Chúng tôi đồng hành cùng khách hàng từ giai đoạn tư vấn, phát triển đến vận hành, luôn đặt chất lượng và trải nghiệm người dùng lên hàng đầu.',
            'story_image' => $this->storeUnsplashImage('photo-1562813733-b31f71025d54', 'about'),
            'vision' => 'Trở thành công ty công nghệ hàng đầu, mang giải pháp số hóa đến mọi doanh nghiệp.',
            'mission' => 'Đồng hành cùng khách hàng xây dựng sản phẩm công nghệ chất lượng, tối ưu chi phí và thời gian.',
        ])->save();

        $values = [
            ['icon' => 'pi-heart', 'title' => 'Tận tâm', 'description' => 'Luôn đặt lợi ích khách hàng lên hàng đầu trong mọi dự án.'],
            ['icon' => 'pi-verified', 'title' => 'Chất lượng', 'description' => 'Cam kết chất lượng sản phẩm qua từng dòng code.'],
            ['icon' => 'pi-bolt', 'title' => 'Sáng tạo', 'description' => 'Không ngừng cập nhật công nghệ mới để mang lại giải pháp tối ưu.'],
        ];

        foreach ($values as $order => $data) {
            AboutValue::firstOrCreate(['title' => $data['title']], [...$data, 'order' => $order]);
        }

        $stats = [
            ['value' => '50+', 'label' => 'Dự án hoàn thành'],
            ['value' => '30+', 'label' => 'Khách hàng tin tưởng'],
            ['value' => '5+', 'label' => 'Năm kinh nghiệm'],
            ['value' => '15+', 'label' => 'Chuyên gia công nghệ'],
        ];

        foreach ($stats as $order => $data) {
            AboutStat::firstOrCreate(['label' => $data['label']], [...$data, 'order' => $order]);
        }
    }

    /**
     * Downloads a fixed Unsplash photo (by id) into the public disk, unless
     * it's already there, and returns the relative path for a model column.
     */
    private function storeUnsplashImage(string $photoId, string $folder): string
    {
        $path = "{$folder}/{$photoId}.jpg";

        if (! Storage::disk('public')->exists($path)) {
            $response = Http::timeout(15)->get("https://images.unsplash.com/{$photoId}", [
                'w' => 1200,
                'q' => 80,
                'auto' => 'format',
                'fit' => 'crop',
            ]);

            $response->throw();

            Storage::disk('public')->put($path, $response->body());
        }

        return $path;
    }
}
