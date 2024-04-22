import fitz
import sys
import re

# 1ページ目の最大の文字サイズのテキストをタイトルとする
def get_title(doc):
    page = doc[0]
    largest_fontsize = 0
    largest_fontsize_texts = []
    blocks = page.get_text("dict")["blocks"]
    for b in blocks:
        for l in b["lines"]:
            for s in l["spans"]:
                if s['size'] > largest_fontsize:
                    largest_fontsize = s['size']
                    largest_fontsize_texts = [s['text']]
                elif s['size'] == largest_fontsize:
                    largest_fontsize_texts.append(s['text'])
    return "".join(largest_fontsize_texts)

def main():
    path = "../pdf/古川卒論 _final.pdf"
    document = []
    doc = fitz.open(path)
    title = get_title(doc)
    print(title)


if __name__ == "__main__":
    main()