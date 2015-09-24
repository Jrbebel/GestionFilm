<?php
namespace AppBundle\Security\Core\Authentication\Provider;

use Escape\WSSEAuthenticationBundle\Security\Core\Authentication\Provider\Provider as BaseProvider;

class Provider extends BaseProvider
{
     public function authenticate(TokenInterface $token){
    $user = $this->userProvider->loadUserByUsername($token->getUsername());
    if(!$user){
      throw new AuthenticationException("Bad credentials... Did you forgot your username ?");
    }
    if ($user && 
    $this->validateDigest($token->digest, $token->nonce, $token->created, $user->getPassword())) {
      // ...
    }
  }

  protected function validateDigest($digest, $nonce, $created, $secret){
        
    // Check created time is not in the future
    if (strtotime($created) > time()) {
      throw new AuthenticationException("Back to the future...");
    }

    // Expire timestamp after 5 minutes
    if (time() - strtotime($created) > 300) {
      throw new AuthenticationException("Too late for this timestamp... Watch your watch.");
    }

    // Validate nonce is unique within 5 minutes
    if (file_exists($this->cacheDir.'/'.$nonce) && file_get_contents($this->cacheDir.'/'.$nonce) + 300 > time()) {
      throw new NonceExpiredException('Previously used nonce detected');
    }

    // If cache directory does not exist we create it
    if (!is_dir($this->cacheDir)) {
      mkdir($this->cacheDir, 0777, true);
    }

    file_put_contents($this->cacheDir.'/'.$nonce, time());

    // Validate Secret
    $expected = base64_encode(sha1(base64_decode($nonce).$created.$secret, true));

    if($digest !== $expected){
      throw new AuthenticationException("Bad credentials ! Digest is not as expected.");
    }

    return true;
  }
}


