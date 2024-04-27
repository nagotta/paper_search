import fitz
import sys
import re

def contains_year(text):
    # 文字列内の数字をすべて取り出す
    numbers = re.findall('[0-9]+', text)
    
    valid_years = []
    for item in numbers:
        year = int(item)

        # 論文の発行年数の下限はわからないので"1950"で仮置き
        if 1950 <= year <= 2050:
            valid_years.append(item)    
            return True

    return False

def get_references(doc):
    references = []

    for page_num in range(len(doc)):
        page = doc.load_page(page_num)
        texts = page.get_text()
        lines = texts.split('\n')

        for n in range(len(lines)):
            match = re.findall(r"\[\d+\]\s", lines[n])
            if match:
                for i in range(1, 5):
                    if len(lines) > n + i:

                        # 5行以内で、年数を探す
                        if contains_year(lines[n + i]):
                            ref = []
                            for j in range(i+1):
                                ref.append(lines[n + j])
                            references.append("".join(ref))
                            break
    return references







def main():
    argv = sys.argv
    print("cur : "+os.getcwd())
    print("argv[0] : "+argv[0])
    print("argv[1] : "+argv[1])
    # 引数でPDFファイルpath受け取り
    path = argv[0]
    document = []
    doc = fitz.open(path)
    references = get_references(doc)
    print(references)


if __name__ == "__main__":
    main()
