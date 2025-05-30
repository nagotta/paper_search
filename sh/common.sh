# .envファイルを読み込む関数
load_env() {
    local env_file="../.env"
    if [ -f "$env_file" ]; then
        source "$env_file"
    else
        echo ".envファイルが見つかりません" >&2
        exit 1
    fi
}