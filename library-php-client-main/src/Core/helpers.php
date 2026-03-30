<?php
function h($value): string
{
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function setFlash(string $type, string $message): void
{
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function pullFlash(): ?array
{
    if (empty($_SESSION['flash'])) {
        return null;
    }

    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
    return $flash;
}

function redirectTo(string $section, string $apiBaseUrl, array $query = []): void
{
    $params = array_merge(['section' => $section, 'api_base_url' => $apiBaseUrl], $query);
    header('Location: ?' . http_build_query($params));
    exit;
}

function normalizeArray($value): array
{
    return is_array($value) ? $value : [];
}

function entityNameById(array $items, int $id): string
{
    foreach ($items as $item) {
        if ((int)($item['id'] ?? 0) === $id) {
            return trim((string)($item['name'] ?? ''));
        }
    }
    return '-';
}

function imageDataUrl($image): string
{
    if (empty($image)) {
        return '';
    }

    if (is_array($image)) {
        if (!empty($image['data'])) {
            $image = $image['data'];
        } elseif (!empty($image['base64'])) {
            $image = $image['base64'];
        } elseif (!empty($image['content'])) {
            $image = $image['content'];
        } else {
            return '';
        }
    }

    $image = trim((string)$image);
    if ($image === '') {
        return '';
    }

    if (strpos($image, 'data:image/') === 0) {
        return $image;
    }

    $decoded = base64_decode($image, true);
    if ($decoded === false) {
        return '';
    }

    $mimeType = 'image/jpeg';

    if (function_exists('finfo_buffer')) {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        if ($finfo !== false) {
            $detectedMimeType = finfo_buffer($finfo, $decoded);
            if (is_string($detectedMimeType) && strpos($detectedMimeType, 'image/') === 0) {
                $mimeType = $detectedMimeType;
            }
            finfo_close($finfo);
        }
    }

    return 'data:' . $mimeType . ';base64,' . $image;
}

function clampStars(int $stars): int
{
    if ($stars < 0) {
        return 0;
    }
    if ($stars > 5) {
        return 5;
    }
    return $stars;
}