<?php
// ===================================================================
class Imagem {
	// ===============================================================
	public static function imagemCopiaRedimensionada($img_origem, $img_destino, $largura_max, $altura_max, $dimensoesfixas = false) {
		$tam_img = getimagesize($img_origem);
		$largura_orig = $tam_img[0];
		$altura_orig = $tam_img[1];
		$tipo_imagem = $tam_img[2];
		$largura = $largura_orig;
		$altura = $altura_orig;
		if (($largura_orig > $largura_max) || ($altura_orig > $altura_max)) {
			$tam_img = self::imagemNovasDimensoes($altura_orig, $largura_orig, $altura_max, $largura_max, $dimensoesfixas);
			$largura = $tam_img[0];
			$altura = $tam_img[1];

			switch ($tipo_imagem) {
				case 1: $imagem = @imagecreatefromgif($img_origem); break;
				case 2: $imagem = @imagecreatefromjpeg($img_origem); break;
				case 3: $imagem = @imagecreatefrompng($img_origem); break;
			}

			if (!$imagem) return false;
			$imgtemp = imagecreatetruecolor($largura, $altura);
			imagecopyresampled($imgtemp, $imagem, 0, 0, 0, 0, $largura, $altura, $largura_orig, $altura_orig);

			if ($dimensoesfixas) {
				if ($altura > $altura_max) {
					$altura2 = ($altura - $altura_max) / 2;
					$imgtemp2 = imagecreatetruecolor($largura_max, $altura_max);
					imagecopy($imgtemp2, $imgtemp, 0, 0, 0, $altura2, $largura, $altura_max);
					imagedestroy($imgtemp);
					$imgtemp = $imgtemp2;
				} elseif ($largura > $largura_max) {
					$largura2 = ($largura - $largura_max) / 2;
					$imgtemp2 = imagecreatetruecolor($largura_max, $altura_max);
					imagecopy($imgtemp2, $imgtemp, 0, 0, $largura2, 0, $largura_max, $altura);
					imagedestroy($imgtemp);
					$imgtemp = $imgtemp2;
				}
			}

			switch ($tipo_imagem) {
				case 1: imagegif($imgtemp, $img_destino); break;
				case 2: imagejpeg($imgtemp, $img_destino, 80); break;
				case 3: imagepng($imgtemp, $img_destino); break;
			}
			imagedestroy($imgtemp);
		} else {
			copy($img_origem, $img_destino);
		}
		return true;
	}
	// ===============================================================
	private static function imagemNovasDimensoes($altura_orig, $largura_orig, $altura_max, $largura_max, $semproporcao = false) {
		$largura = $largura_orig;
		$altura = $altura_orig;
		if ($altura > $largura) {
			if ($largura > $largura_max) {
				$altura = ($altura_orig * $largura_max) / $largura_orig;
				$largura = $largura_max;
			}
			if (($altura > $altura_max) && !$semproporcao) {
				$largura = ($largura * $altura_max) / $altura;
				$altura = $altura_max;
			}
		} else {
			if ($altura > $altura_max) {
				$largura = ($largura * $altura_max) / $altura;
				$altura = $altura_max;
			}
			if (($largura > $largura_max) && !$semproporcao) {
				$altura = ($altura_orig * $largura_max) / $largura_orig;
				$largura = $largura_max;
			}
		}
		return array($largura, $altura);
	}
	// ===============================================================
}
// ===================================================================