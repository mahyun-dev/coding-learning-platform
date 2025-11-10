# TODO: 한국어 현지화 가이드 (Korean Localization Guide)

이 문서는 코딩 학습 플랫폼의 한국어 현지화를 위한 상세 가이드입니다.

## 📋 현재 상태

- ✅ README.md 한국어 번역 완료
- ✅ issues/1.md 한국어 번역 완료
- ⚠️ 웹 애플리케이션 코드 미구현 (향후 개발 필요)

## 🎯 향후 현지화 작업 항목

### 1. 프론트엔드 UI 현지화

#### 1.1 로그인 페이지 (`login.php` 또는 `login.html`)

**필요한 한국어 텍스트:**
```
- 페이지 제목: "로그인"
- 사용자명 라벨: "사용자명" 또는 "아이디"
- 비밀번호 라벨: "비밀번호"
- 로그인 버튼: "로그인"
- 회원가입 링크: "계정이 없으신가요? 회원가입"
- 비밀번호 찾기 링크: "비밀번호를 잊으셨나요?"
```

**오류 메시지:**
```
- "사용자명을 입력해주세요"
- "비밀번호를 입력해주세요"
- "사용자명 또는 비밀번호가 올바르지 않습니다"
- "계정이 비활성화되었습니다"
```

#### 1.2 회원가입 페이지 (`register.php` 또는 `register.html`)

**필요한 한국어 텍스트:**
```
- 페이지 제목: "회원가입"
- 사용자명 라벨: "사용자명"
- 이메일 라벨: "이메일"
- 비밀번호 라벨: "비밀번호"
- 비밀번호 확인 라벨: "비밀번호 확인"
- 이름 라벨: "이름"
- 회원가입 버튼: "가입하기"
- 로그인 링크: "이미 계정이 있으신가요? 로그인"
```

**오류 메시지:**
```
- "모든 필드를 입력해주세요"
- "유효한 이메일 주소를 입력해주세요"
- "비밀번호는 최소 8자 이상이어야 합니다"
- "비밀번호가 일치하지 않습니다"
- "이미 사용 중인 사용자명입니다"
- "이미 등록된 이메일입니다"
```

**성공 메시지:**
```
- "회원가입이 완료되었습니다"
- "로그인 페이지로 이동합니다"
```

#### 1.3 문제 목록 페이지 (`problems.php` 또는 `problems.html`)

**필요한 한국어 텍스트:**
```
- 페이지 제목: "문제 목록"
- 테이블 헤더:
  - "번호"
  - "제목"
  - "난이도"
  - "정답률"
  - "상태"
- 난이도 레벨:
  - "쉬움"
  - "보통"
  - "어려움"
- 상태:
  - "미해결"
  - "해결됨"
  - "시도함"
- 필터/정렬:
  - "난이도별 필터"
  - "상태별 필터"
  - "검색"
```

#### 1.4 문제 상세 페이지 (`problem_detail.php`)

**필요한 한국어 텍스트:**
```
- 섹션 제목:
  - "문제 설명"
  - "입력 형식"
  - "출력 형식"
  - "제약 조건"
  - "예제 입력"
  - "예제 출력"
  - "힌트"
- 버튼:
  - "코드 제출"
  - "코드 실행"
  - "초기화"
  - "저장"
- 코드 에디터 플레이스홀더:
  - "여기에 코드를 작성하세요..."
- 언어 선택:
  - "프로그래밍 언어 선택:"
```

#### 1.5 제출 결과 페이지 (`submission.php`)

**필요한 한국어 텍스트:**
```
- 결과 상태:
  - "정답"
  - "오답"
  - "컴파일 에러"
  - "런타임 에러"
  - "시간 초과"
  - "메모리 초과"
  - "출력 형식 오류"
  - "채점 중"
- 상세 정보:
  - "제출 시간"
  - "실행 시간"
  - "메모리 사용량"
  - "언어"
  - "코드 길이"
```

#### 1.6 대시보드 (`dashboard.php`)

**필요한 한국어 텍스트:**
```
- 페이지 제목: "대시보드"
- 통계 카드:
  - "해결한 문제"
  - "제출 횟수"
  - "정답률"
  - "현재 순위"
- 섹션 제목:
  - "최근 제출"
  - "추천 문제"
  - "학습 진도"
- 차트/그래프:
  - "일일 활동"
  - "난이도별 해결 현황"
```

#### 1.7 네비게이션 메뉴

**필요한 한국어 텍스트:**
```
- "홈"
- "문제"
- "대시보드"
- "순위"
- "내 프로필"
- "로그아웃"
- "설정"
```

### 2. 백엔드 API 응답 현지화

#### 2.1 인증 API

**API 엔드포인트:** `/api/auth/login`, `/api/auth/register`

**응답 메시지 예시:**
```php
// 성공 응답
[
    'success' => true,
    'message' => '로그인에 성공했습니다',
    'data' => [...]
]

// 실패 응답
[
    'success' => false,
    'message' => '사용자명 또는 비밀번호가 올바르지 않습니다',
    'error_code' => 'AUTH_FAILED'
]
```

**필요한 메시지:**
```
✅ 성공:
- "로그인에 성공했습니다"
- "회원가입이 완료되었습니다"
- "비밀번호가 재설정되었습니다"

❌ 오류:
- "사용자명 또는 비밀번호가 올바르지 않습니다"
- "유효하지 않은 요청입니다"
- "세션이 만료되었습니다. 다시 로그인해주세요"
- "권한이 없습니다"
- "이미 사용 중인 사용자명입니다"
- "유효하지 않은 이메일 형식입니다"
```

#### 2.2 문제 API

**API 엔드포인트:** `/api/problems`, `/api/problems/{id}`

**필요한 메시지:**
```
✅ 성공:
- "문제 목록을 불러왔습니다"
- "문제 상세 정보를 불러왔습니다"

❌ 오류:
- "문제를 찾을 수 없습니다"
- "문제 목록을 불러오는데 실패했습니다"
```

#### 2.3 제출 API

**API 엔드포인트:** `/api/submit`

**필요한 메시지:**
```
✅ 성공:
- "코드가 제출되었습니다"
- "채점이 완료되었습니다"

❌ 오류:
- "코드를 제출할 수 없습니다"
- "지원하지 않는 프로그래밍 언어입니다"
- "코드 길이가 제한을 초과했습니다"
- "너무 많은 제출 요청입니다. 잠시 후 다시 시도해주세요"
```

### 3. 데이터베이스 현지화

#### 3.1 문제 데이터

문제 테이블에 한국어 컬럼이 필요합니다:

```sql
CREATE TABLE problems (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title_ko VARCHAR(255) NOT NULL,          -- 한국어 제목
    description_ko TEXT NOT NULL,             -- 한국어 설명
    input_format_ko TEXT,                     -- 한국어 입력 형식
    output_format_ko TEXT,                    -- 한국어 출력 형식
    constraints_ko TEXT,                      -- 한국어 제약 조건
    hint_ko TEXT,                             -- 한국어 힌트
    difficulty ENUM('쉬움', '보통', '어려움'),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

#### 3.2 예제 데이터

```sql
CREATE TABLE problem_examples (
    id INT PRIMARY KEY AUTO_INCREMENT,
    problem_id INT NOT NULL,
    input_ko TEXT NOT NULL,                   -- 한국어 예제 입력
    output_ko TEXT NOT NULL,                  -- 한국어 예제 출력
    explanation_ko TEXT,                      -- 한국어 설명
    FOREIGN KEY (problem_id) REFERENCES problems(id)
);
```

### 4. 이메일 템플릿 현지화

#### 4.1 회원가입 확인 이메일

```
제목: [코딩 학습 플랫폼] 회원가입을 환영합니다

안녕하세요, {사용자명}님!

코딩 학습 플랫폼에 가입해주셔서 감사합니다.

아래 링크를 클릭하여 이메일 인증을 완료해주세요:
{인증_링크}

문의사항이 있으시면 언제든지 연락주세요.

감사합니다.
코딩 학습 플랫폼 팀
```

#### 4.2 비밀번호 재설정 이메일

```
제목: [코딩 학습 플랫폼] 비밀번호 재설정 요청

안녕하세요, {사용자명}님!

비밀번호 재설정 요청을 받았습니다.

아래 링크를 클릭하여 새 비밀번호를 설정해주세요:
{재설정_링크}

이 링크는 24시간 동안 유효합니다.

본인이 요청하지 않은 경우, 이 이메일을 무시해주세요.

감사합니다.
코딩 학습 플랫폼 팀
```

### 5. 설정 및 환경 파일

#### 5.1 config.php

```php
<?php
// 언어 설정
define('DEFAULT_LANGUAGE', 'ko');
define('SUPPORTED_LANGUAGES', ['ko']);

// 날짜/시간 형식 (한국 표준)
define('DATE_FORMAT', 'Y년 m월 d일');
define('TIME_FORMAT', 'H:i:s');
define('DATETIME_FORMAT', 'Y년 m월 d일 H:i');
define('TIMEZONE', 'Asia/Seoul');

// 메시지
define('MESSAGES', [
    'success' => [
        'login' => '로그인에 성공했습니다',
        'register' => '회원가입이 완료되었습니다',
        'submit' => '코드가 제출되었습니다',
        'update' => '정보가 업데이트되었습니다',
        'delete' => '삭제되었습니다'
    ],
    'error' => [
        'login_failed' => '사용자명 또는 비밀번호가 올바르지 않습니다',
        'invalid_input' => '유효하지 않은 입력입니다',
        'not_found' => '요청한 자원을 찾을 수 없습니다',
        'unauthorized' => '권한이 없습니다',
        'server_error' => '서버 오류가 발생했습니다. 잠시 후 다시 시도해주세요'
    ]
]);
?>
```

### 6. JavaScript/Frontend 현지화

#### 6.1 validation.js

```javascript
const messages = {
    required: '필수 입력 항목입니다',
    email: '유효한 이메일 주소를 입력해주세요',
    minLength: '최소 {length}자 이상 입력해주세요',
    maxLength: '최대 {length}자까지 입력 가능합니다',
    passwordMatch: '비밀번호가 일치하지 않습니다',
    invalidFormat: '형식이 올바르지 않습니다'
};

// 확인 대화상자
const confirmMessages = {
    delete: '정말 삭제하시겠습니까?',
    logout: '로그아웃하시겠습니까?',
    submit: '제출하시겠습니까?'
};

// 알림 메시지
const alertMessages = {
    saveSuccess: '저장되었습니다',
    saveFailed: '저장에 실패했습니다',
    loading: '처리 중...',
    networkError: '네트워크 오류가 발생했습니다'
};
```

### 7. 관리자 패널 현지화

#### 7.1 관리자 대시보드

**필요한 한국어 텍스트:**
```
- 페이지 제목: "관리자 패널"
- 메뉴 항목:
  - "사용자 관리"
  - "문제 관리"
  - "제출 관리"
  - "시스템 설정"
  - "통계"
- 액션 버튼:
  - "추가"
  - "수정"
  - "삭제"
  - "활성화"
  - "비활성화"
  - "내보내기"
  - "가져오기"
```

### 8. 에러 페이지

#### 8.1 404 페이지 (`404.php`)

```html
<h1>페이지를 찾을 수 없습니다</h1>
<p>요청하신 페이지가 존재하지 않거나 이동되었습니다.</p>
<a href="/">홈으로 돌아가기</a>
```

#### 8.2 500 페이지 (`500.php`)

```html
<h1>서버 오류</h1>
<p>죄송합니다. 서버에서 오류가 발생했습니다.</p>
<p>잠시 후 다시 시도해주세요.</p>
<a href="/">홈으로 돌아가기</a>
```

### 9. 접근성 (Accessibility)

#### 9.1 ARIA 라벨

HTML 요소에 한국어 ARIA 라벨 추가:

```html
<button aria-label="메뉴 열기">☰</button>
<input type="search" aria-label="문제 검색" placeholder="문제 검색...">
<nav aria-label="주 네비게이션">...</nav>
```

### 10. SEO 및 메타데이터

#### 10.1 HTML 헤드 섹션

```html
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="한국어로 배우는 코딩 학습 플랫폼">
    <meta name="keywords" content="코딩, 프로그래밍, 학습, 알고리즘, 문제 풀이">
    <meta property="og:title" content="코딩 학습 플랫폼">
    <meta property="og:description" content="한국어로 배우는 코딩 학습 플랫폼">
    <meta property="og:locale" content="ko_KR">
    <title>코딩 학습 플랫폼</title>
</head>
```

## 📝 구현 단계별 가이드

### 단계 1: 프로젝트 구조 설정

1. 언어 파일 디렉토리 생성:
   ```
   /lang
     /ko
       - auth.php
       - problems.php
       - validation.php
       - messages.php
   ```

2. 각 언어 파일에 키-값 쌍으로 메시지 저장

### 단계 2: 다국어 헬퍼 함수 작성

```php
<?php
// lang_helper.php

function __($key, $params = []) {
    global $lang;
    $translation = $lang[$key] ?? $key;
    
    foreach ($params as $param_key => $param_value) {
        $translation = str_replace('{' . $param_key . '}', $param_value, $translation);
    }
    
    return $translation;
}

function load_language($language = 'ko') {
    global $lang;
    $lang_file = __DIR__ . "/lang/{$language}/messages.php";
    
    if (file_exists($lang_file)) {
        $lang = include $lang_file;
    } else {
        $lang = [];
    }
}
?>
```

### 단계 3: 뷰 파일에서 사용

```php
<?php load_language('ko'); ?>

<h1><?php echo __('login_title'); ?></h1>
<form>
    <label><?php echo __('username_label'); ?></label>
    <input type="text" placeholder="<?php echo __('username_placeholder'); ?>">
    
    <label><?php echo __('password_label'); ?></label>
    <input type="password" placeholder="<?php echo __('password_placeholder'); ?>">
    
    <button><?php echo __('login_button'); ?></button>
</form>
```

### 단계 4: JavaScript 현지화

```javascript
// 언어 데이터 로드
const lang = {
    required: '필수 입력 항목입니다',
    submit_confirm: '제출하시겠습니까?',
    // ...
};

// 사용
alert(lang.submit_confirm);
```

### 단계 5: API 응답 현지화

```php
<?php
function api_response($success, $message_key, $data = null) {
    header('Content-Type: application/json; charset=utf-8');
    
    echo json_encode([
        'success' => $success,
        'message' => __($message_key),
        'data' => $data
    ], JSON_UNESCAPED_UNICODE);
}

// 사용 예
if ($login_success) {
    api_response(true, 'login_success', ['user' => $user_data]);
} else {
    api_response(false, 'login_failed');
}
?>
```

## ✅ 테스트 체크리스트

개발 완료 후 다음 사항들을 확인하세요:

- [ ] 모든 페이지가 한국어로 표시되는가?
- [ ] 모든 버튼과 라벨이 한국어로 되어있는가?
- [ ] 모든 오류 메시지가 한국어로 표시되는가?
- [ ] 모든 성공 메시지가 한국어로 표시되는가?
- [ ] API 응답이 한국어로 반환되는가?
- [ ] 이메일 템플릿이 한국어로 되어있는가?
- [ ] 날짜/시간 형식이 한국 표준(KST)인가?
- [ ] 에러 페이지(404, 500)가 한국어로 되어있는가?
- [ ] HTML lang 속성이 "ko"로 설정되어있는가?
- [ ] 메타데이터와 SEO 태그가 한국어로 되어있는가?
- [ ] 접근성 라벨이 한국어로 되어있는가?
- [ ] 확인 대화상자 메시지가 한국어로 되어있는가?

## 🔍 추가 고려사항

### 문화적 적절성

1. **호칭**: 공손한 표현 사용 (~하세요, ~합니다)
2. **날짜 형식**: YYYY년 MM월 DD일
3. **시간대**: Asia/Seoul (KST)
4. **통화**: 필요시 원화(₩) 사용
5. **전화번호 형식**: 010-XXXX-XXXX

### 성능 최적화

1. 언어 파일은 캐싱하여 매번 로드하지 않도록 함
2. 번역된 문자열을 세션에 저장하여 재사용
3. 필요한 번역만 로드 (Lazy Loading)

### 유지보수

1. 새로운 기능 추가 시 반드시 한국어 번역도 함께 추가
2. 언어 파일은 버전 관리 시스템에 포함
3. 주기적으로 번역의 자연스러움 검토
4. 사용자 피드백을 통한 번역 개선

## 📚 참고 자료

- PHP 다국어 처리: [PHP gettext](https://www.php.net/manual/en/book.gettext.php)
- JavaScript 다국어: [i18next](https://www.i18next.com/)
- 한국어 웹 접근성 가이드: [한국형 웹 콘텐츠 접근성 지침](https://www.wah.or.kr/)
- 한글 타이포그래피: [한글 웹 폰트](https://fonts.google.com/?subset=korean)

## 🔄 업데이트 로그

- 2025-11-10: 초기 문서 작성
  - 한국어 현지화 가이드 작성 완료
  - UI, API, 데이터베이스 현지화 항목 정의
  - 구현 단계별 가이드 작성

---

**이 문서는 프로젝트가 확장됨에 따라 지속적으로 업데이트되어야 합니다.**
