import fitz
import os
import sys

# PDF内の画像を取り出す
def get_images(doc):
    # 現状の課題
    # 1. 余計な画像も抽出される
    # 2. おそらく卒論形式しか取得できない

    filename = sys.argv[1]
    pdf_file = fitz.open(filename)
    num_of_pics = 0

    filename_without_extension = os.path.splitext(filename)[0]
    os.makedirs(filename_without_extension, exist_ok=True)

    for page in pdf_file:             
        images = page.get_images()
        if not len(images) == 0:
            for image in images:
                num_of_pics += 1 
                xref = image[0]
                img = pdf_file.extract_image(xref)
                with open(f"./{filename_without_extension}/extracted_image{num_of_pics}.png", "wb") as f:
                    f.write(img["image"])

    return num_of_pics


    pdf_file.close()

def main():
    # スクリプト実行時に引数でファイルパスを受けとる
    argv = sys.argv
    filename = argv[1]
    get_images(filename)

if __name__ == "__main__":
    main()

# [Reference](https://hogelog.com/python/pymupdf-3-html.html)