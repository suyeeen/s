import sys
import json
import numpy as np

def kmeans_clustering(data, k=4, max_iter=100, random_state=42):
    """
    K-Means dari scratch tanpa sklearn
    Input : list of dict {guru_id, pedagogik, profesional, sosial, kepribadian}
    Output: list of dict {guru_id, cluster, pedagogik, profesional, sosial, kepribadian}
    """
    if len(data) < k:
        k = len(data)  # Kalau guru < 4, sesuaikan k

    # Ambil fitur
    features = np.array([
        [
            float(d.get('pedagogik',   0) or 0),
            float(d.get('profesional', 0) or 0),
            float(d.get('sosial',      0) or 0),
            float(d.get('kepribadian', 0) or 0),
        ]
        for d in data
    ])

    np.random.seed(random_state)

    # ── Inisialisasi centroid (ambil k data random) ──────────────────────────
    idx       = np.random.choice(len(features), k, replace=False)
    centroids = features[idx].copy()

    labels = np.zeros(len(features), dtype=int)

    for _ in range(max_iter):
        # ── Assignment: setiap data ke centroid terdekat ─────────────────────
        new_labels = np.array([
            np.argmin([np.linalg.norm(f - c) for c in centroids])
            for f in features
        ])

        # ── Update centroid ──────────────────────────────────────────────────
        new_centroids = np.array([
            features[new_labels == i].mean(axis=0)
            if len(features[new_labels == i]) > 0
            else centroids[i]
            for i in range(k)
        ])

        # ── Cek konvergen ────────────────────────────────────────────────────
        if np.allclose(centroids, new_centroids):
            labels = new_labels
            centroids = new_centroids
            break

        labels    = new_labels
        centroids = new_centroids

    # ── Map cluster ke label A/B/C/D berdasarkan rata-rata skor centroid ─────
    # Cluster dengan skor tertinggi = A, terendah = D
    centroid_means = centroids.mean(axis=1)
    rank_order     = np.argsort(centroid_means)[::-1]  # descending
    cluster_labels = {}
    for rank, cluster_idx in enumerate(rank_order):
        cluster_labels[int(cluster_idx)] = chr(65 + rank)  # A, B, C, D

    label_map = {
        'A': 'Sangat Baik',
        'B': 'Baik',
        'C': 'Cukup',
        'D': 'Perlu Pembinaan',
    }

    # ── Susun hasil ──────────────────────────────────────────────────────────
    results = []
    for i, d in enumerate(data):
        cluster_letter = cluster_labels[int(labels[i])]
        nilai_list     = features[i]
        rata_rata      = round(float(nilai_list.mean()), 2)

        results.append({
            'guru_id':         d['guru_id'],
            'cluster':         cluster_letter,
            'label_cluster':   label_map[cluster_letter],
            'nilai_pedagogik':  round(float(nilai_list[0]), 2),
            'nilai_profesional':round(float(nilai_list[1]), 2),
            'nilai_sosial':     round(float(nilai_list[2]), 2),
            'nilai_kepribadian':round(float(nilai_list[3]), 2),
            'nilai_rata_rata':  rata_rata,
        })

    return results


def hitung_rata_nilai(jawaban_list):
    """
    Hitung rata-rata nilai per kategori dari list jawaban
    """
    kategori = ['pedagogik', 'profesional', 'sosial', 'kepribadian']
    hasil    = {}

    for kat in kategori:
        nilai_kat = [j['nilai'] for j in jawaban_list if j['kategori'] == kat]
        hasil[kat] = round(sum(nilai_kat) / len(nilai_kat), 2) if nilai_kat else 0.0

    return hasil


if __name__ == '__main__':
    try:
        # Terima data dari stdin (dikirim Laravel)
        raw   = sys.stdin.read()
        input_data = json.loads(raw)

        mode = input_data.get('mode', 'clustering')

        if mode == 'hitung_nilai':
            # Mode: hitung rata-rata nilai per guru dari jawaban mentah
            guru_jawaban = input_data.get('data', [])
            output = []
            for guru in guru_jawaban:
                nilai = hitung_rata_nilai(guru['jawaban'])
                output.append({
                    'guru_id': guru['guru_id'],
                    **nilai
                })
            print(json.dumps({'status': 'ok', 'data': output}))

        elif mode == 'clustering':
            # Mode: langsung clustering dari nilai yang sudah dihitung
            guru_data = input_data.get('data', [])

            if len(guru_data) == 0:
                print(json.dumps({'status': 'error', 'message': 'Tidak ada data guru'}))
                sys.exit(1)

            results = kmeans_clustering(guru_data, k=min(4, len(guru_data)))
            print(json.dumps({'status': 'ok', 'data': results}))

        else:
            print(json.dumps({'status': 'error', 'message': f'Mode tidak dikenal: {mode}'}))
            sys.exit(1)

    except json.JSONDecodeError as e:
        print(json.dumps({'status': 'error', 'message': f'JSON invalid: {str(e)}'}))
        sys.exit(1)
    except Exception as e:
        print(json.dumps({'status': 'error', 'message': str(e)}))
        sys.exit(1)
